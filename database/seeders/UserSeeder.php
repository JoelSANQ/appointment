<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Administrador
        User::factory()->create([
            'name' => 'Admin Sistema',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'id_numero' => '0000000001',
            'phone' => '000-000-0000',
            'address' => 'Oficina Central',
        ])->assignRole('Administrador');

        // 2. Crear Doctor Joel
        User::factory()->create([
            'name' => 'Joel Sanchez',
            'email' => 'joel@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            'id_numero' => '1234567890',
            'phone' => '123-456-7890',
            'address' => 'MAXCANU city',
        ])->assignRole('Doctor');
    }
}
