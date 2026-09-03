<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Les mots de passe ci-dessous sont les hachages bcrypt EXACTS fournis
     * (déjà générés par password_hash / Hash::make côté application).
     * Si vous voulez plutôt des mots de passe de test connus en clair,
     * remplacez chaque valeur par Hash::make('votre_mdp_de_test').
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['id' => 1],
            [
                'nom'               => 'Lamine',
                'prenom'            => 'Mahamane',
                'matricule'         => '11AAA',
                'telephone'         => '89667000',
                'email'             => 'mahamanelmn8@gmail.com',
                'email_verified_at' => null,
                'password'          => '$2y$12$aBHsf0DTCgYKZRq41cE.MOuKkTzl9Vd9L8j1SWWV962qr.KVe3BMO',
                'role_id'           => 1,
                'created_at'        => '2025-10-05 13:26:30',
                'updated_at'        => '2025-10-05 13:26:30',
            ]
        );

        DB::table('users')->updateOrInsert(
            ['id' => 22],
            [
                'nom'               => 'Mahaboubou',
                'prenom'            => 'Abdou',
                'matricule'         => 'ADM20241002',
                'telephone'         => '92113434',
                'email'             => 'mahabou@gmail.com',
                'email_verified_at' => null,
                'password'          => '$2y$12$43.YLEnI.xv5rvwp0V1/SOIIbg/qTQ2.39tEJOf/tnCBQQah.Ker2',
                'role_id'           => 1,
                'created_at'        => '2025-10-05 13:26:30',
                'updated_at'        => '2025-10-05 13:26:30',
            ]
        );
    }
}