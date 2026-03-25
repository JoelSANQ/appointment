<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;

if (!User::where('email', 'admin@example.com')->exists()) {
    $user = User::create([
        'name' => 'Administrador Sistema',
        'email' => 'admin@example.com',
        'password' => bcrypt('admin123'),
        'id_numero' => '0000000000',
    ]);
    $user->assignRole('Administrador');
    echo "Admin user created successfully: admin@example.com / admin123\n";
} else {
    echo "Admin user already exists.\n";
}
