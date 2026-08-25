<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function index()
    {
        return response()->json(User::latest()->get());
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricule' => 'required|string|max:25|unique:users,matricule',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|unique:users,telephone',
            'password' => 'nullable',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'matricule' => $request->matricule,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'matricule' => $user->matricule,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ]
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'matricule' => 'required|string|max:25|unique:users,matricule,'.$user->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'telephone' => 'required|unique:users,telephone,'.$user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $data = $request->only(['matricule','nom','prenom','email','telephone','role_id']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'matricule' => $user->matricule,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ]
        ]);
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
            
            // // 🔐 Générer code simple
            // $code = rand(1000, 9999);

            // // Stocker temporairement en session
            // session([
            //     '2fa_user_id' => $user->id,
            //     '2fa_code' => $code,
            // ]);
            
            // Mail::raw(
            //     "Votre code de confirmation est : $code",
            //     function ($message) use ($user) {
            //         $message->from(config('mail.from.address'), config('mail.from.name'));
            //         $message->to($user->email)
            //                 ->subject('Code de confirmation');
            //     }
            // );
            // return response()->json([
            //     'message' => 'Code de confirmation envoyé par email'
            // ]);
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'matricule' => $user->matricule,
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'email' => $user->email,
                    'role_id' => $user->role_id,
                ],
                'token' => $token,
            ]);
        } catch (\Exception $th) {
            Log::error('Erreur de login: ' . $th->getMessage());
            return response()->json(['error' => 'Validation échouée', 'message' => $th->getMessage()], 500);
        }

    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric',
        ]);

        // if (
        //     session('2fa_code') != $request->code ||
        //     !session('2fa_user_id')
        // ) {
        //     return response()->json([
        //         'message' => 'Code de confirmation invalide'
        //     ], 401);
        // }

        // $user = User::find(session('2fa_user_id'));
        $user = User::where('matricule', $request->id)->first();

        // Nettoyer la session
        session()->forget(['2fa_code', '2fa_user_id']);

        // 🔑 Générer le token Sanctum MAINTENANT
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'matricule' => $user->matricule,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ],
            'token' => $token,
        ]);
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
