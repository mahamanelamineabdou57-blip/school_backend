<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions
        Permission::create(['name' => 'manage-students']);
        Permission::create(['name' => 'manage-teachers']);
        Permission::create(['name' => 'manage-finance']);
        Permission::create(['name' => 'manage-exams']);
        Permission::create(['name' => 'view-reports']);
        Permission::create(['name' => 'manage-users']);
        Permission::create(['name' => 'manage-roles']);
        Permission::create(['name' => 'manage-faculties']);
        Permission::create(['name' => 'manage-departments']);
        Permission::create(['name' => 'manage-sections']);
        Permission::create(['name' => 'manage-modules']);
        Permission::create(['name' => 'manage-inscriptions']);
        Permission::create(['name' => 'manage-notes']);
        Permission::create(['name' => 'manage-academic-years']);
        Permission::create(['name' => 'manage-trace-messages']);
        Permission::create(['name' => 'manage-fees']);
        Permission::create(['name' => 'manage-student-fees']);
        Permission::create(['name' => 'manage-unite-enseignements']);
        Permission::create(['name' => 'manage-cartes-etudiants']);

        // Roles
        $admin = Role::create(['name' => 'admin']);
        $enseignant = Role::create(['name' => 'enseignant']);
        $etudiant = Role::create(['name' => 'etudiant']);
        $comptable = Role::create(['name' => 'comptable']);
        $scolarite = Role::create(['name' => 'scolarite']);
        $chef_departement = Role::create(['name' => 'chef_departement']);
        $inscription = Role::create(['name' => 'inscription']);
        $secretaire = Role::create(['name' => 'secretaire']);
        $superadmin = Role::create(['name' => 'superadmin']);
        // Assign Permissions to Roles
        $scolarite->givePermissionTo(['manage-students', 'manage-inscriptions', 'manage-notes', 'manage-academic-years', 'manage-trace-messages']);
        $chef_departement->givePermissionTo(['manage-departments', 'manage-sections', 'manage-modules', 'manage-teachers', 'view-reports']);
        $inscription->givePermissionTo(['manage-inscriptions', 'manage-students']);
        $secretaire->givePermissionTo(['manage-carte-etudiants', 'manage-students']);
        $superadmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(Permission::all());
        $enseignant->givePermissionTo(['manage-exams']);
        $comptable->givePermissionTo(['manage-finance']);
        // Etudiant n'a pas de permission d'édition par défaut
    }
}
