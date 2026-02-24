<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('specialities')->insert([
            ['name' => 'Cardiología'],
            ['name' => 'Pediatría'],
            ['name' => 'Dermatología'],
            ['name' => 'Neurología'],
            ['name' => 'Ginecología'],
            ['name' => 'Oftalmología'],
            ['name' => 'Psiquiatría'],
            ['name' => 'Traumatología']
        ]);
    }
}