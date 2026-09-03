<?php

namespace App\Services;

use App\Models\Etudiant;
use App\Models\PaymentHistory;
use App\Models\StudentFee;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Génère (ou retourne) la facture d'un étudiant pour un type de frais donné.
     * Le montant peut être surchargé (bourse, remise...) sinon on prend le défaut du catalogue.
     */
    public function genererFacture(Etudiant $etudiant, int $feeTypeId, ?int $inscriptionId = null, ?float $montantOverride = null): StudentFee
    {
        $feeType = \App\Models\FeeType::findOrFail($feeTypeId);

        return StudentFee::firstOrCreate(
            [
                'etudiant_id'     => $etudiant->id,
                'fee_type_id'     => $feeTypeId,
                'inscription_id'  => $inscriptionId,
            ],
            [
                'montant_du' => $montantOverride ?? $feeType->montant_defaut,
                'paid_amount' => 0,
                'status' => 'pending',
            ]
        );
    }

    /**
     * Enregistre un versement, recalcule le solde/statut de la facture,
     * et clôture automatiquement les relances ouvertes si elle est soldée.
     * Toute l'opération est atomique.
     *
     * @throws \DomainException si le montant versé dépasse le solde restant
     */
    public function enregistrerVersement(StudentFee $studentFee, array $data): PaymentHistory
    {
        return DB::transaction(function () use ($studentFee, $data) {
            // Verrouille la ligne pour éviter les versements concurrents incohérents
            $studentFee = StudentFee::whereKey($studentFee->id)->lockForUpdate()->firstOrFail();

            $resteAPayer = (float) $studentFee->montant_du - (float) $studentFee->paid_amount;

            if ($data['montant_verse'] > $resteAPayer) {
                throw new \DomainException(
                    "Le montant versé ({$data['montant_verse']}) dépasse le solde restant ({$resteAPayer})."
                );
            }

            $history = $studentFee->paymentHistories()->create([
                'etudiant_id'    => $studentFee->etudiant_id,
                'montant_verse'  => $data['montant_verse'],
                'mode_paiement'  => $data['mode_paiement'],
                'reference'      => $data['reference'] ?? null,
                'note'           => $data['note'] ?? null,
                'enregistre_par' => $data['enregistre_par'] ?? null,
            ]);

            $totalVerse = $studentFee->paymentHistories()->sum('montant_verse');

            $studentFee->update([
                'paid_amount'  => $totalVerse,
                'payment_date' => now()->toDateString(),
                'status'       => match (true) {
                    $totalVerse <= 0 => 'pending',
                    $totalVerse >= $studentFee->montant_du => 'paid',
                    default => 'partial',
                },
            ]);

            if ($studentFee->status === 'paid') {
                $studentFee->paymentReminders()
                    ->whereIn('statut', ['en_attente', 'envoyée'])
                    ->update([
                        'statut'  => 'résolue',
                        'message' => 'Frais soldé automatiquement le ' . now()->format('d/m/Y à H:i'),
                    ]);
            }

            return $history->fresh();
        });
    }

    /**
     * Résumé financier consolidé d'un étudiant, calculé à partir de student_fees
     * (qui est lui-même toujours à jour car dérivé de payment_histories).
     */
    public function resumeEtudiant(Etudiant $etudiant): array
    {
        $studentFees = $etudiant->studentFees()->with('feeType')->get();

        $totalDu    = $studentFees->sum('montant_du');
        $totalVerse = $studentFees->sum('paid_amount');
        $solde      = max(0, $totalDu - $totalVerse);

        return [
            'total_du'      => $totalDu,
            'total_verse'   => $totalVerse,
            'solde_restant' => $solde,
            'statut_global' => $solde == 0 ? 'À jour' : ($totalVerse > 0 ? 'Partiellement payé' : 'Non payé'),
        ];
    }
}