<?php

namespace App\Http\Controllers;

use App\Models\Faculte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FaculteController extends Controller
{
    public function index()
    {
        return response()->json(Faculte::all());
    }

    public function show($id)
    {
        return Faculte::with('departements')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);


        return Faculte::create($request->all());
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'logo' => 'nullable|image|max:2048',
            ]);

            $faculte = Faculte::findOrFail($id);
            $faculte->update($validated);
            return response()->json([
                'message' => 'Faculté mise à jour avec succès',
                'data' => $faculte
            ], 200);
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour faculté: ' . $e->getMessage());
            return response()->json(['error' => 'Validation échouée', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $faculte = Faculte::findOrFail($id);
        $faculte->delete();
        return response()->noContent();
    }
}
