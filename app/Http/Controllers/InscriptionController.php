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
        return Inscription::with('etudiant', 'formation', 'academicYear')->findOrFail($id);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'etudiant_id' => 'required|exists:etudiants,id',
        //     'formation_id' => 'required|exists:formations,id',
        //     'semestre_courant' => 'required|integer|min:1',
        //     'status' => 'required|string|max:50',
        //     'academic_year_id' => 'required|exists:academic_years,id',
        // ]);
        dd($request->all());
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
