<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    public function index()
    {
        return Enseignant::with('departement', 'modules', 'user')->get();
    }

    public function show($id)
    {
        return Enseignant::with('departement', 'modules', 'user')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'departement_id' => 'required|exists:departements,id',
            'user_id' => 'required|exists:users,id',
        ]);

        return Enseignant::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $enseignant->update($request->all());
        return $enseignant;
    }

    public function destroy($id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $enseignant->delete();
        return response()->noContent();
    }
}
