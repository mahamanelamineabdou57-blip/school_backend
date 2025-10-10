<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
        try {
            // $request->validate([
            //     'matricule' => 'nullable|string|max:25|unique:users',
            //     'nom' => 'required|string|max:255',
            //     'prenom' => 'required|string|max:255',
            //     'email' => 'required|email|unique:users,email',
            //     'telephone' => 'required|unique:users,telephone',
            //     'role_id' => 'required|exists:roles,id',
            // ]);

            // Générer mot de passe aléatoire personnalisé
            $plainPassword = $request->prenom. 1234;

            $user = User::create([
                'matricule' => $request->matricule,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'password' => Hash::make($plainPassword),
                'role_id' => $request->role_id,
            ]);

            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'password' => $plainPassword, // ⚠️ pour que l’utilisateur se connecte
            ], 201);
        } catch (\Exception $e) {
            Log::error('Erreur Create utilisateur: '.$e->getMessage());

            return response()->json(['error' => 'Erreur lors de la création de l\'utilisateur.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'matricule' => 'string|max:25|unique:users,matricule,'.$user->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'telephone' => 'required|unique:users,telephone,'.$user->id,
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
        try {
            $request->validate([
                'matricule' => 'required',
                'password' => 'required|string',
            ]);

            $user = User::where('matricule', $request->matricule)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'matricule' => ['Les identifiants sont incorrects.'],
                ]);
            }

            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $th) {
            Log::error('Erreur de login: ' . $th->getMessage());
            return response()->json(['error' => 'Validation échouée', 'message' => $th->getMessage()], 500);
        }

    }

    // 🔹 Logout
    public function logout(Request $request)
    {
        // Supprime tous les tokens de l’utilisateur connecté
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.',
        ]);
    }
}
