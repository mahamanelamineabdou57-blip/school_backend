<?php

namespace App\Http\Controllers;

use App\Models\Inteface;
use Illuminate\Http\Request;

class IntefaceController extends Controller
{
    public function index()
    {
        // return Departement::with('faculte', 'sections', 'enseignants')->get();
        return response()->json(Inteface::all());
    }

    public function show($id)
    {
        return Inteface::findOrFail($id);
    }
    public function store(Request $request)
    {

        $interface = Inteface::create($request->all());

        return response()->json([
            'interface' => $interface,
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $interface = Inteface::findOrFail($id);
        // $request->validate([
        //     'matricule' => 'string|max:25|unique:users,matricule,' . $user->id,
        //     'nom' => 'required|string|max:255',
        //     'prenom' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email,' . $user->id,
        //     'telephone' => 'required|unique:users,telephone,' . $user->id,
        //     'role_id' => 'required',
        // ]);
        $interface->update($request->all());
        return response()->json($interface);
    }
    public function destroy($id)
    {
        $user = Inteface::findOrFail($id);
        $user->delete();
        return response()->noContent();
    }
}
