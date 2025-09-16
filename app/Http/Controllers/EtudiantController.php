<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index()
    {
        return Etudiant::with('section', 'inscriptions', 'notes', 'user')->get();
    }

    public function show($id)
    {
        return Etudiant::with('section', 'inscriptions', 'notes', 'user')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'nullable|email',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string',
            'section_id' => 'required|exists:sections,id',
            'user_id' => 'required|exists:users,id',
        ]);

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
