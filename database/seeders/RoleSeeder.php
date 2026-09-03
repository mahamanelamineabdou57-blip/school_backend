<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->updateOrInsert(
            ['id' => 1],
            [
                'nom'         => 'Administrateur',
                'description' => 'lorem ipsum',
                'created_at'  => '2025-10-05 13:26:30',
                'updated_at'  => '2025-10-05 13:26:30',
            ]
        );
    }
}