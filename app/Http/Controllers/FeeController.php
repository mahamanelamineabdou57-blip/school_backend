<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        return Fee::with('inscription')->get();
    }

    public function show($id)
    {
        return Fee::with('inscription')->findOrFail($id);
    }

    public function store(Request $request)
    {
        try {
            //code...
             $validated= $request->validate([
            'inscriptionId' => 'required|exists:inscriptions,id',
            'type' => 'required|in:inscription,formation',
            'montant' => 'required|numeric|min:0',
            'datePaiement' => 'nullable|date',
            'statut' => 'required|in:non payé,partiellement payé,payé',
            // 'name' => 'required|string|max:255',
            // 'amount' => 'required|numeric|min:0',
            // 'description' => 'nullable|string',
        ]);

        $fee = Fee::create($validated);
        return response()->json([
            'message' => 'Frais créé avec succès',
            'data' => $fee
        ], 201);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to create fee', 'message' => $th->getMessage()], 500);
            //throw $th;
        }
       
    }

    public function update(Request $request, $id)
    {
        $fee = Fee::findOrFail($id);
        $fee->update($request->all());
        return $fee;
    }

    public function destroy($id)
    {
        $fee = Fee::findOrFail($id);
        $fee->delete();
        return response()->noContent();
    }
}
