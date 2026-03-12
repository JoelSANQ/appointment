<?php

use Illuminate\Support\Facades\Route;

// Cargar las rutas de administración
require __DIR__.'/admin.php';

// Redirigir la raíz al panel de administración
Route::redirect('/', '/admin');

// Rutas protegidas por autenticación
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Ruta del dashboard principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});