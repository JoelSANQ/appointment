<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
// 👈 AGREGA ESTA LÍNEA

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definir roles
        $roles = [
            'Paciente',
            'Doctor',
            'Recepcionista',
<<<<<<< HEAD
            'Administrador'
=======
            'Administrador',
>>>>>>> 463f42e (feat(roles): complete CRUD workflow with edit restrictions and delete confirmation)
        ];

        // Crear en la BD
        foreach ($roles as $role) {
            Role::create([
                'name' => $role
            ]);
        }
    }
}
