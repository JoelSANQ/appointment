<?php

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view ('admin.dashboard');
})->name('dashboard');

Route::resource('roles', RoleController::class);
