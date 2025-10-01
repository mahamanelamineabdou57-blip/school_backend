<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    public function index()
    {
        // return Inscription::with('etudiant', 'formation', 'academicYear')->get();
        return response()->json(Inscription::all(), 200);
    }

    public function show($id)
    {
        return response()->json(Inscription::findOrFail($id), 200);
        // return Inscription::with('etudiant', 'formation', 'academicYear')->findOrFail($id);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'etudiant_id' => 'required|exists:etudiants,id',
                'formation_id' => 'required|exists:formations,id',
                'semestre_courant' => 'required|integer|min:1|max:10',  // Ajout max pour sécurité (ex. : 10 semestres max)
                'status' => 'nullable|in:en_cours,terminé',  // Nullable + enum strict (remplace string|max)
                'anneeScolaire_id' => 'required|exists:academic_years,id',
            ], [
                'etudiant_id.required' => 'L\'ID étudiant est obligatoire.',
                'etudiant_id.exists' => 'L\'étudiant sélectionné n\'existe pas.',
                'formation_id.required' => 'L\'ID formation est obligatoire.',
                'formation_id.exists' => 'La formation sélectionnée n\'existe pas.',
                'semestre_courant.required' => 'Le semestre courant est obligatoire.',
                'semestre_courant.integer' => 'Le semestre doit être un nombre entier.',
                'status.in' => 'Le statut doit être "en_cours" ou "terminé".',
                'anneeScolaire_id.required' => 'L\'année scolaire est obligatoire.',
                'anneeScolaire_id.exists' => 'L\'année scolaire sélectionnée n\'existe pas.',
            ]);
            // dd($request->all());
            // return Inscription::create($request->all());
            $inscription = Inscription::create($validated);
            return response()->json([
                'message' => 'Inscription créée avec succès',
                'data' => $inscription
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Validation échouée: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $inscription = Inscription::findOrFail($id);
        $inscription->update($request->all());
        return $inscription;
    }

    public function destroy($id)
    {
        $inscription = Inscription::findOrFail($id);
        $inscription->delete();
        return response()->noContent();
    }
}
