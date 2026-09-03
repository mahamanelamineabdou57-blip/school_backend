<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\StudentFee;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class StudentFeeController extends Controller
{
    public function __construct(protected PaymentService $paymentService) {}

    public function index(Request $request)
    {
        $query = StudentFee::with('etudiant', 'feeType')->latest();

        if ($request->has('etudiant_id')) {
            $query->where('etudiant_id', $request->etudiant_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->paginate(20));
    }

    public function show(StudentFee $studentFee)
    {
        return $studentFee->load('etudiant', 'feeType', 'paymentHistories');
    }

    /**
     * Génère une facture pour un étudiant à partir d'un type de frais du catalogue.
     * N'accepte PAS de statut ou de paid_amount en entrée : ces champs ne sont
     * jamais définis manuellement, uniquement via PaymentService::enregistrerVersement().
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiant_id'      => 'required|exists:etudiants,id',
            'fee_type_id'      => 'required|exists:fee_types,id',
            'inscription_id'   => 'nullable|exists:inscriptions,id',
            'montant_override' => 'nullable|numeric|min:0',
        ]);

        $etudiant = Etudiant::findOrFail($validated['etudiant_id']);

        try {
            $studentFee = $this->paymentService->genererFacture(
                $etudiant,
                $validated['fee_type_id'],
                $validated['inscription_id'] ?? null,
                $validated['montant_override'] ?? null
            );

            return response()->json([
                'message' => 'Facture générée avec succès',
                'data'    => $studentFee,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error'   => 'Échec de la génération de la facture',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Ne permet de modifier que le montant dû (ex: remise accordée après coup).
     * paid_amount / status / payment_date restent hors de portée de cet endpoint.
     */
    public function update(Request $request, StudentFee $studentFee)
    {
        $validated = $request->validate([
            'montant_du' => 'sometimes|numeric|min:0',
        ]);

        $studentFee->update($validated);

        return $studentFee;
    }

    public function destroy(StudentFee $studentFee)
    {
        $studentFee->delete();
        return response()->noContent();
    }
}
