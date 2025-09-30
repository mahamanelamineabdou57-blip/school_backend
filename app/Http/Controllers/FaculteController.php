<?php

namespace App\Http\Controllers;

use App\Models\Faculte;
use Illuminate\Http\Request;

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
        $faculte = Faculte::findOrFail($id);
        $faculte->update($request->all());
        return $faculte;
    }

    public function destroy($id)
    {
        $faculte = Faculte::findOrFail($id);
        $faculte->delete();
        return response()->noContent();
    }
}
