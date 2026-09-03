<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ordre imposé par les clés étrangères :
     * roles doit exister avant users (role_id),
     * users et intefaces doivent exister avant acces (utilisateur_id, inteface_id).
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            InterfaceSeeder::class,
            AccesSeeder::class,
        ]);
    }
}