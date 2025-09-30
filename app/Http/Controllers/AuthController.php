<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        // return Departement::with('faculte', 'sections', 'enseignants')->get();
        return response()->json(User::all());
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }
    //  Register(creation de compte)
    public function store(Request $request)
    {
        $request->validate([
            'matricule' => 'string|max:25|unique:users',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|unique:users,telephone',
            'password' => 'required|string|min:6|confirmed', // password_confirmation
            'role_id' => 'required',
        ]);
        $user = User::create($request->all());
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'matricule' => 'string|max:25|unique:users,matricule,' . $user->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'required|unique:users,telephone,' . $user->id,
            'role_id' => 'required',
        ]);
        $user->update($request->all());
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->noContent();
    }
    // Login (authentification)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Les identifiants sont incorrects.'],
            ]);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    // 🔹 Logout
    public function logout(Request $request)
    {
        // Supprime tous les tokens de l’utilisateur connecté
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.'
        ]);
    }
}
