<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesPermisos extends Seeder
{
    public function run()
    {
        // Crear permisos solo si no existen
        $manageUsers = Permission::firstOrCreate(['name' => 'manage users']);
        $manageBeneficiaries = Permission::firstOrCreate(['name' => 'manage beneficiaries']);

        // Crear roles solo si no existen
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $agentRole = Role::firstOrCreate(['name' => 'Agent']);

        // Asignar permisos a roles
        $adminRole->givePermissionTo($manageUsers);
        $agentRole->givePermissionTo($manageBeneficiaries);

        // Crear usuario Admin si no existe
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password') // Cambia esto si es producción
            ]
        );
        $adminUser->assignRole($adminRole);

        // Crear usuario Agente si no existe
        $agentUser = User::firstOrCreate(
            ['email' => 'agent@example.com'],
            [
                'name' => 'Agent',
                'password' => bcrypt('password') // Cambia esto si es producción
            ]
        );
        $agentUser->assignRole($agentRole);
    }
}
