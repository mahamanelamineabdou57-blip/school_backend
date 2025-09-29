<?php

namespace App\Http\Controllers;

use App\Models\UniteEnseignement;
use Illuminate\Http\Request;

class UniteEnseignementController extends Controller
{
    // Lister tous les UE
    public function index() 
    {
        $ues = UniteEnseignement::with('sections', 'modules')->get();
        return response()->json($ues);
    }

    // Créer un UE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:unite_enseignements,code',
            'credits' => 'required|integer|min:0',
            'section_id' => 'required|exists:sections,id',
        ]);

        $ue = UniteEnseignement::create($validated);
        return response()->json($ue, 201);
    }

    // Afficher un UE spécifique
    public function show($id)
    {
        $ue = UniteEnseignement::with('sections', 'modules')->findOrFail($id);
        return response()->json($ue);
    }

    // Mettre à jour un UE
    public function update(Request $request, $id)
    {
        $ue = UniteEnseignement::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:50|unique:unite_enseignements,code,' . $id,
            'credits' => 'sometimes|required|integer|min:0',
            'section_id' => 'sometimes|required|exists:sections,id',
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
