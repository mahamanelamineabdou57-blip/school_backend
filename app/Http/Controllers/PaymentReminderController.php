<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\PaymentReminder;
use App\Models\StudentFee;
use Illuminate\Http\Request;

class PaymentReminderController extends Controller
{
    /**
     * Liste tous les étudiants ayant des frais impayés ou partiellement payés.
     */
    public function unpaid()
    {
        $impayés = StudentFee::with(['etudiant', 'feeType'])
            ->whereIn('status', ['pending', 'partial'])
            ->get()
            ->groupBy('etudiant_id')
            ->map(function ($fees, $etudiantId) {
                $etudiant   = $fees->first()->etudiant;
                $totalDu    = $fees->sum('montant_du');
                $totalVerse = $fees->sum('paid_amount');

                return [
                    'etudiant_id'   => $etudiantId,
                    'matricule'     => $etudiant?->matricule,
                    'nom_complet'   => trim(($etudiant?->prenom ?? '') . ' ' . ($etudiant?->nom ?? '')),
                    'email'         => $etudiant?->email,
                    'total_du'      => $totalDu,
                    'total_verse'   => $totalVerse,
                    'reste_a_payer' => max(0, $totalDu - $totalVerse),
                    'student_fees'  => $fees->pluck('id'),
                ];
            })
            ->values();

        return response()->json([
            'count' => $impayés->count(),
            'data'  => $impayés,
        ]);
    }

    /**
     * Enregistre une relance pour chaque facture impayée d'un étudiant.
     * Rattachée à student_fee_id (et non plus etudiant_id + fee_id séparément)
     * pour lever toute ambiguïté en cas de factures multiples du même type.
     */
    public function send(Request $request, $etudiantId)
    {
        $validated = $request->validate([
            'canal'   => 'required|in:email,sms,manuel',
            'message' => 'nullable|string|max:1000',
        ]);

        $etudiant = Etudiant::findOrFail($etudiantId);

        $studentFees = StudentFee::with('feeType')
            ->where('etudiant_id', $etudiantId)
            ->whereIn('status', ['pending', 'partial'])
            ->get();

        if ($studentFees->isEmpty()) {
            return response()->json([
                'message' => "Cet étudiant n'a aucun frais impayé.",
            ], 422);
        }

        $reminders = $studentFees->map(fn ($sf) => PaymentReminder::create([
            'student_fee_id' => $sf->id,
            'date_relance'   => now()->toDateString(),
            'canal'          => $validated['canal'],
            'statut'         => 'envoyée',
            'message'        => $validated['message'] ?? $this->defaultMessage($etudiant, $sf),
        ]));

        return response()->json([
            'message'  => $reminders->count() . ' relance(s) enregistrée(s) pour ' . $etudiant->prenom . ' ' . $etudiant->nom,
            'relances' => $reminders,
        ], 201);
    }

    /**
     * Historique de toutes les relances avec filtre optionnel par étudiant ou statut.
     */
    public function index(Request $request)
    {
        $query = PaymentReminder::with('studentFee.etudiant', 'studentFee.feeType')->latest();

        if ($request->has('etudiant_id')) {
            $query->whereHas('studentFee', fn ($q) => $q->where('etudiant_id', $request->etudiant_id));
        }

        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }

        return response()->json($query->paginate(20));
    }

    private function defaultMessage(Etudiant $etudiant, StudentFee $sf): string
    {
        return "Cher(e) {$etudiant->prenom} {$etudiant->nom}, nous vous rappelons que vous avez un solde impayé de {$sf->reste_a_payer} FCFA. Merci de régulariser votre situation.";
    }
}