<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\CalendarController;

Route::middleware(['auth:sanctum', 'verified'])->name('admin.')->prefix('admin')->group(function () {
    
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::get('appointments/{appointment}/consultation', [AppointmentController::class, 'consultation'])->name('appointments.consultation');
    Route::post('appointments/{appointment}/consultation', [AppointmentController::class, 'storeConsultation'])->name('appointments.consultation.store');
    Route::post('appointments/{appointment}/reminder', [AppointmentController::class, 'sendReminder'])->name('appointments.send-reminder');

    // Calendario
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('calendar/events', [CalendarController::class, 'events'])->name('calendar.events');

    // Horarios de doctores (Gestionado desde el listado de doctores)
    Route::get('doctors/{doctor}/schedule', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::post('doctors/{doctor}/schedule', [ScheduleController::class, 'store'])->name('schedule.store');

    // API interna para búsqueda de disponibilidad
    Route::get('available-doctors', [AppointmentController::class, 'getAvailableDoctors'])->name('appointments.available-doctors');

});