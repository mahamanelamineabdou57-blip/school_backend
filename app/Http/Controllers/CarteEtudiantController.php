<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarteEtudiant;
use App\Models\Inscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


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
         try {
        // On récupère l'inscription correspondante pour générer le numéro de carte
        $request->validate([
            'inscriptions_id' => 'required|exists:inscriptions,id',
            // 'status' => 'required|string',
        ]);
        // dd($request->all());

        // Récupérer l'inscription
        $inscription = Inscription::findOrFail($request->inscriptions_id);
        // dd($inscription);
        // Générer le numéro de carte : numéro_inscription + deux derniers chiffres de l'année
        $annee = date('Y'); // année en cours
        $anneeSuffixe = substr($annee, -2); // derniers chiffres de l'année
        $numeroCarte = '00'.$inscription->id . '-' . $anneeSuffixe;

        // Vérifier unicité (optionnel, mais conseillé)
        if (CarteEtudiant::where('numero_carte', $numeroCarte)->exists()) {
            return response()->json(['message' => 'Le numéro de carte existe déjà'], 422);
        }

        // Créer la carte
        $carteEtudiant = CarteEtudiant::create([
            'numero_carte' => $numeroCarte,
            'inscriptions_id' => $request->inscriptions_id,
            'status' => $request->status,
        ]);

        return response()->json($carteEtudiant, 201);
        } catch (\Exception $e) {
            Log::error('Erreur Create Etudiant: ' . $e);
            return response()->json(['error' => 'Validation échouée'], 500);
        }
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
