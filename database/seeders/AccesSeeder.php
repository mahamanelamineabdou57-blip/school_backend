<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccesSeeder extends Seeder
{
    /**
     * droit = "lecture_ecriture_suppression" pour toutes les lignes fournies.
     * Utilisateur 1 (Lamine)     -> Configuration, Faculte, Scolarite, Paiement
     * Utilisateur 22 (Mahaboubou)-> Dashboard, Configuration, Faculte, Scolarite, Paiement
     */
    public function run(): void
    {
        $acces = [
            ['id' => 1, 'droits' => 'lecture_ecriture_suppression', 'inteface_id' => 1, 'utilisateur_id' => 1],
            ['id' => 2, 'droits' => 'lecture_ecriture_suppression', 'inteface_id' => 2, 'utilisateur_id' => 1],
            ['id' => 3, 'droits' => 'lecture_ecriture_suppression', 'inteface_id' => 3, 'utilisateur_id' => 1],
            ['id' => 4, 'droits' => 'lecture_ecriture_suppression', 'inteface_id' => 4, 'utilisateur_id' => 1],
            ['id' => 5, 'droits' => 'lecture_ecriture_suppression', 'inteface_id' => 5, 'utilisateur_id' => 22],
            ['id' => 6, 'droits' => 'lecture_ecriture_suppression', 'inteface_id' => 1, 'utilisateur_id' => 22],
            ['id' => 7, 'droits' => 'lecture_ecriture_suppression', 'inteface_id' => 2, 'utilisateur_id' => 22],
            ['id' => 8, 'droits' => 'lecture_ecriture_suppression', 'inteface_id' => 3, 'utilisateur_id' => 22],
            ['id' => 9, 'droits' => 'lecture_ecriture_suppression', 'inteface_id' => 4, 'utilisateur_id' => 22],
        ];

        foreach ($acces as $row) {
            DB::table('acces')->updateOrInsert(
                ['id' => $row['id']],
                [
                    'droits'          => $row['droits'],
                    'inteface_id'     => $row['inteface_id'],
                    'utilisateur_id'  => $row['utilisateur_id'],
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]
            );
        }
    }
}