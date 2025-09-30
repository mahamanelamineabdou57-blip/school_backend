<?php

namespace App\Http\Controllers;

use App\Models\Acces;
use App\Models\User;
use Illuminate\Http\Request;

class AccesController extends Controller
{
    public function index()
    {
        // return Departement::with('faculte', 'sections', 'enseignants')->get();
        return response()->json(Acces::all());
    }

    public function show($id)
    {
        return Acces::findOrFail($id);
    }
    public function store(Request $request)
    {
        $acces = Acces::create($request->all());
        return response()->json([
            'acces' => $acces,
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $acces = Acces::findOrFail($id);
        // $request->validate([
        //     'matricule' => 'string|max:25|unique:users,matricule,' . $user->id,
        //     'nom' => 'required|string|max:255',
        //     'prenom' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email,' . $user->id,
        //     'telephone' => 'required|unique:users,telephone,' . $user->id,
        //     'role_id' => 'required',
        // ]);
        $acces->update($request->all());
        return response()->json($acces);
    }
    public function destroy($id)
    {
        $acces = Acces::findOrFail($id);
        $acces->delete();
        return response()->noContent();
    }

    public function getUserAccess($id)
    {
        // $userAccess = user::with('acces', 'inteface')->find($id);

        // $userAccess = Acces::where('utilisateur_id',$id)->get();
        // return $userAccess;
          $userAccess = Acces::with('inteface')
        ->where('utilisateur_id', $id)
        ->get();
        return response()->json($userAccess);
    }
}
