<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index()
    {
        // return Departement::with('faculte', 'sections', 'enseignants')->get();
         return Departement::with('faculte', 'sections')->get();
    }

    public function show($id)
    {
        return Departement::with('faculte', 'sections', 'enseignants')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'faculte_id' => 'required|exists:facultes,id',
        ]);

        return Departement::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $departement = Departement::findOrFail($id);
        $departement->update($request->all());
        return $departement;
    }

    public function destroy($id)
    {
        $departement = Departement::findOrFail($id);
        $departement->delete();
        return response()->noContent();
    }
}
