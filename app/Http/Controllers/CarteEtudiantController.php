<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarteEtudiant;
use App\Http\Controllers\Controller;


class CarteEtudiantController extends Controller
{
    // Controller methods will go here
    public function index()
    {
        $carteEtudiant = CarteEtudiant::with('inscription')->get();
        return response()->json($carteEtudiant);
    }
    public function show($id)
    {
        $carteEtudiant = CarteEtudiant::with('inscription')->find($id);
        if (!$carteEtudiant) {
            return response()->json(['message' => 'Carte Etudiant not found'], 404);
        }
        return response()->json($carteEtudiant);
    }
    public function store(Request $request)
    {
        // Code to create a new student card
        $validatedData = $request->validate([
            'numero_carte' => 'required|unique:carte_etudiants,numero_carte',
            'inscriptions_id' => 'required|exists:inscriptions,id',
            'status' => 'required|string|in:active,inactive,lost,expired',
        ]);
        // dd($validatedData);
        // Create the student card
        $carteEtudiant = CarteEtudiant::create($validatedData);
        return response()->json($carteEtudiant, 201);
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'numero_carte' => 'sometimes|required|unique:carte_etudiants,numero_carte,' . $id,
            'inscriptions_id' => 'sometimes|required|exists:inscriptions,id',
            'date_emission' => 'sometimes|required|date',
            'date_expiration' => 'sometimes|required|date|after:date_emission',
            'status' => 'sometimes|required|string|in:active,inactive,lost,expired',
        ]);
        $carteEtudiant = CarteEtudiant::find($id);
        if (!$carteEtudiant) {
            return response()->json(['message' => 'Carte Etudiant not found'], 404);
        }
        $carteEtudiant->update($validatedData);
        return response()->json($carteEtudiant);
        // Code to update a specific student card
    }
    public function destroy($id)
    {
        CarteEtudiant::find($id)->delete();
        return response()->json(['message' => 'Carte Etudiant deleted successfully']);
    }
}
