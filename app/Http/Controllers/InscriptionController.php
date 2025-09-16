<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    public function index()
    {
        return Inscription::with('etudiant', 'section', 'academicYear')->get();
    }

    public function show($id)
    {
        return Inscription::with('etudiant', 'section', 'academicYear')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'section_id' => 'required|exists:sections,id',
            'inscription_date' => 'required|date',
            'status' => 'required|string|max:50',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        return Inscription::create($request->all());
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
