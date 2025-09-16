<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $note =Note::with('etudiant', 'module', 'section', 'academicYear')->get();
        return $note;
    }

    public function show($id)
    {
        return Note::with('etudiant', 'module', 'section', 'academicYear')->findOrFail($id);
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
}
