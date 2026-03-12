<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        // Obtenemos solo los usuarios con rol de Doctor
        $users = User::role(User::ROLE_DOCTOR)->get();

        foreach ($users as $user) {
            Doctor::create([
                'user_id'                => $user->id, // Mantiene el orden según el ID del usuario
                'speciality_id'          => null,      // Vacío para que respete el N/A
                'medical_license_number' => null,      // Vacío
                'biography'              => null,      // Vacío
            ]);
        }
    }
}