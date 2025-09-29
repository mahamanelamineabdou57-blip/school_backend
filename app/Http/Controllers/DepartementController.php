<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index()
    {
        // return Departement::with('faculte', 'sections', 'enseignants')->get();
         return response()->json(Departement::with('facultes', 'sections')->get());
    }

    public function show($id)
    {
        return Departement::with('facultes', 'sections')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'faculte_id' => 'required',
            'code'=>'nullable|string|max:255',
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
