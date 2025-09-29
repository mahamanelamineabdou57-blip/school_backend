<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //  Register(creation de compte)
    public function register(Request $request)
    {
        $request->validate([
            'matricule' => 'string|max:25|unique',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|telephone|unique:users,telephone',
            'password' => 'required|string|min:6|confirmed', // password_confirmation

        ]);

        $user = User::create([
            'matricule'=> $request->matricule,
            'name' => $request->name,
            'prenom'=> $request->prenom,
            'email' => $request->email,
            'telephone'=> $request->telephone,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
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
