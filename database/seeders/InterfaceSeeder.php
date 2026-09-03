<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterfaceSeeder extends Seeder
{
    /**
     * Nom de table volontairement "intefaces" (sans 'r') pour correspondre
     * exactement à la migration create_intefaces_table existante.
     */
    public function run(): void
    {
        $interfaces = [
            1 => 'Configuration',
            2 => 'Faculte',
            3 => 'Scolarite',
            4 => 'Paiement',
            5 => 'Dashboard',
        ];

        foreach ($interfaces as $id => $nom) {
            DB::table('intefaces')->updateOrInsert(
                ['id' => $id],
                [
                    'nom'        => $nom,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}