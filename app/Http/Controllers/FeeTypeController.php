<?php

namespace App\Http\Controllers;

use App\Models\FeeType;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    public function index()
    {
        return FeeType::latest()->get();
    }

    public function show(FeeType $feeType)
    {
        return $feeType;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'              => 'required|in:inscription,formation',
            'libelle'           => 'required|string|max:255',
            'montant_defaut'    => 'required|numeric|min:0',
            'academic_year_id'  => 'nullable|exists:academic_years,id',
            'formation_id'      => 'nullable|exists:formations,id',
        ]);

        $feeType = FeeType::create($validated);

        return response()->json([
            'message' => 'Type de frais créé avec succès',
            'data'    => $feeType,
        ], 201);
    }

    public function update(Request $request, FeeType $feeType)
    {
        $validated = $request->validate([
            'type'              => 'sometimes|in:inscription,formation',
            'libelle'           => 'sometimes|string|max:255',
            'montant_defaut'    => 'sometimes|numeric|min:0',
            'academic_year_id'  => 'nullable|exists:academic_years,id',
            'formation_id'      => 'nullable|exists:formations,id',
        ]);

        $feeType->update($validated);

        return $feeType;
    }

    public function destroy(FeeType $feeType)
    {
        $feeType->delete();
        return response()->noContent();
    }
}