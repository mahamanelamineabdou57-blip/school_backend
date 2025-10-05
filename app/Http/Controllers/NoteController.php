<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        return response()->json(Note::with('inscriptions')->get());
    }

    public function show($id)
    {
        return Note::with('inscriptions')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'valeur' => 'required|numeric|min:0|max:20',
            'etudiant_id' => 'required|exists:etudiants,id',
            'module_id' => 'required|exists:modules,id',
            'section_id' => 'required|exists:sections,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        return Note::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);
        $note->update($request->all());
        return $note;
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        return response()->noContent();
    }
    // Nouvelle méthode pour le stockage en batch
    public function batchStore(Request $request)
    {
        $validated = $request->validate([
            '*.noteSessionNormale' => 'nullable|numeric|min:0|max:20',
            '*.noteRattrapage' => 'nullable|numeric|min:0|max:20',
            '*.inscriptionId' => 'required|exists:inscriptions,id',
            '*.ecueId' => 'required|exists:modules,id',
        ]);
        $notes = [];
        foreach ($request->all() as $noteData) {
            $notes[] = Note::create($noteData);
        }
        return response()->json($notes, 201);
    }
    public function getByECUE($ecueId)
    {
        $notes = Note::where('ecueId', $ecueId)->get();
        return response()->json($notes);
    }
}       
// }