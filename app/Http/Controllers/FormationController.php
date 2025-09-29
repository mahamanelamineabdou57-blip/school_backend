<?php

namespace App\Http\Controllers;

use App\Models\Formation; 
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index()
    {
        // return Departement::with('faculte', 'sections', 'enseignants')->get();
        return response()->json(Formation::get());
    }

    public function show($id)
    {
        return response()->json(Formation::findOrFail($id));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'duree' => 'required|integer',
            'conditions' => 'required|string',
            'departement_id' => 'required|exists:departements,id',
        ]);

        return Formation::create($request->all());
    }
    public function update(Request $request, $id)
    {
        $formation = Formation::findOrFail($id);
        $formation->update($request->all());
        return $formation;
    }
    public function destroy($id)
    {
        $formation = Formation::findOrFail($id);
        $formation->delete();
        return response()->noContent();
    }
}
