<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\StudentFee;
use App\Services\PaymentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function __construct(protected PaymentService $paymentService)
    {
    }

    /**
     * Retourne l'historique complet de paiements d'un étudiant.
     */
    public function byEtudiant($etudiantId)
    {
        $etudiant = Etudiant::with([
            'studentFees.feeType',
            'studentFees.paymentHistories.enregistrePar',
        ])->findOrFail($etudiantId);

        return response()->json([
            'etudiant' => $etudiant->only(['id', 'matricule', 'nom', 'prenom', 'email']),
            'resume'   => $this->paymentService->resumeEtudiant($etudiant),
            'student_fees' => $etudiant->studentFees->map(fn($sf) => [
                'id'            => $sf->id,
                'fee_type'      => optional($sf->feeType)->libelle,
                'montant_du'    => $sf->montant_du,
                'montant_verse' => $sf->paid_amount,
                'reste_a_payer' => $sf->reste_a_payer,
                'statut'        => $sf->status,
                'payment_date'  => $sf->payment_date,
                'transactions'  => $sf->paymentHistories->map(fn($ph) => [
                    'id'             => $ph->id,
                    'montant_verse'  => $ph->montant_verse,
                    'mode_paiement'  => $ph->mode_paiement,
                    'reference'      => $ph->reference,
                    'note'           => $ph->note,
                    'enregistre_par' => optional($ph->enregistrePar)->name,
                    'date'           => $ph->created_at?->format('d/m/Y H:i'),
                ]),
            ]),
        ]);
    }

    /**
     * Enregistre un nouveau versement via le PaymentService (transaction atomique,
     * refuse le surpaiement, met à jour statut + relances automatiquement).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_fee_id' => 'required|exists:student_fees,id',
            'montant_verse'  => 'required|numeric|min:0.01',
            'mode_paiement'  => 'required|in:espèces,virement,mobile_money,chèque',
            'reference'      => 'nullable|string|max:100',
            'note'           => 'nullable|string|max:500',
            'enregistre_par' => 'nullable|exists:users,id',
        ]);

        $studentFee = StudentFee::findOrFail($validated['student_fee_id']);

        try {
            $history = $this->paymentService->enregistrerVersement($studentFee, $validated);

            return response()->json([
                'message'     => 'Paiement enregistré avec succès',
                'transaction' => $history,
                'student_fee' => $studentFee->fresh(),
            ], 201);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'error'   => "Échec de l'enregistrement du paiement",
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Exporte l'historique de paiement d'un étudiant en PDF.
     */
    public function exportPdf($etudiantId)
    {
        $etudiant = Etudiant::with([
            'studentFees.feeType',
            'studentFees.paymentHistories.enregistrePar',
            'inscriptions.formation',
            'inscriptions.academicYear',
        ])->findOrFail($etudiantId);

        $inscription = $etudiant->inscriptions->sortByDesc('created_at')->first();
        $resume      = $this->paymentService->resumeEtudiant($etudiant);

        $pdf = Pdf::loadView('pdf.payment_history', [
            'etudiant'    => $etudiant,
            'inscription' => $inscription,
            'totalDu'     => $resume['total_du'],
            'totalVerse'  => $resume['total_verse'],
            'solde'       => $resume['solde_restant'],
        ])->setPaper('a4', 'portrait');

        $filename = 'historique_paiements_' . $etudiant->matricule . '_' . now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}