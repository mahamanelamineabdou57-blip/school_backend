<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index()
    {
        return response()->json(Etudiant::all());
        //
        // return Etudiant::all();
    }

    public function show($id)
    {
        return response()->json(Etudiant::findOrFail($id));
        // return Etudiant::findOrFail($id);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //    'matricule' => 'required|string|unique:etudiants,matricule',
        //    'nom' => 'required|string|max:50',
        //    'prenom' => 'required|string|max:50',
        //    'email' => 'required|email|unique:etudiants,email',
        //    'dateNaissance' => 'nullable|date',
        //    'lieuNaissance' => 'nullable|string|max:255',
        //    'telephone' => 'required|string|max:20',
        //    'adresse' => 'nullable|string|max:255',
        //    'photo' => 'nullable|string|max:255',
        //    'contact_nom' => 'nullable|string|max:50',
        //    'contact_prenom' => 'nullable|string|max:50',
        //    'contact_telephone' => 'nullable|string|max:20',
        //    'contact_email' => 'nullable|email|max:255',
        //    'contact_lien' => 'nullable|string|max:100',
        // ]);
        // dd($request->all());
        return Etudiant::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->update($request->all());
        return $etudiant;
    }

    public function destroy($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();
        return response()->noContent();
    }
}
