<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        return response()->json(Note::with('inscriptions')->latest()->get());

        // $query = Note::query();

        // if ($request->has('ecueId')) {
        //     $query->where('ecueId', $request->ecueId);
        // }

        // return response()->json($query->get());
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

    public function batchStore(Request $request)
    {
        $validated = $request->validate([
            '*.noteSessionNormale' => 'nullable|numeric|min:0|max:20',
            '*.noteRattrapage' => 'nullable|numeric|min:0|max:20',
            '*.inscriptionId' => 'required|exists:inscriptions,id',
            '*.ecueId' => 'required|exists:modules,id',
        ]);

        $notes = [];

        foreach ($validated as $noteData) {
            $notes[] = Note::updateOrCreate(
                [
                    'inscriptionId' => $noteData['inscriptionId'],
                    'ecueId' => $noteData['ecueId'],
                ],
                [
                    'noteSessionNormale' => $noteData['noteSessionNormale'],
                    'noteRattrapage' => $noteData['noteRattrapage'],
                ]
            );
        }

        return response()->json($notes, 200);
    }

    public function getByECUE($ecueId)
    {
        $notes = Note::where('ecueId', $ecueId)->latest()->get();
        return response()->json($notes);
    }
}
