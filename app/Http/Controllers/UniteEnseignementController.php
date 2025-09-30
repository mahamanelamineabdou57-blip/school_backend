<?php

namespace App\Http\Controllers;

use App\Models\UniteEnseignement;
use Illuminate\Http\Request;

class UniteEnseignementController extends Controller
{
    // Lister tous les UE
    public function index()
    {
        $ues = UniteEnseignement::with('formation')->get();
        return response()->json($ues);
    }

    // Créer un UE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:unite_enseignements,code',
            'formation_id' => 'required|exists:formations,id',
        ]);
        // dd($validated);
        $ue = UniteEnseignement::create($request->all());
        return response()->json($ue, 201);
    }

    // Afficher un UE spécifique
    public function show($id)
    {
        $ue = UniteEnseignement::with('formation')->findOrFail($id);
        return response()->json($ue);
    }

    // Mettre à jour un UE
    public function update(Request $request, $id)
    {
        $ue = UniteEnseignement::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:unite_enseignements,code',
            'credits' => 'required|integer|min:0',
            'formation_id' => 'required|exists:sections,id',
        ]);

        $ue->update($validated);
        return response()->json($ue);
    }

    // Supprimer un UE
    public function destroy($id)
    {
        $ue = UniteEnseignement::findOrFail($id);
        $ue->delete();
        return response()->json(['message' => 'Unité d\'enseignement supprimée']);
    }
}
