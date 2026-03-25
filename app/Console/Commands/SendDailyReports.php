<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDailyReports extends Command
{
    protected $signature = 'appointments:daily-reports';
    protected $description = 'Envía reportes diarios de citas al administrador y a los doctores a las 8:00 AM.';

    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $formattedDate = Carbon::today()->format('d/m/Y');

        $allAppointments = Appointment::where('date', $today)
            ->where('status', '!=', 'Cancelado')
            ->with(['patient.user', 'doctor.user'])
            ->orderBy('time')
            ->get();

        $this->info("Procesando {$allAppointments->count()} citas para hoy.");

        try {
            // 1. Enviar reporte al administrador
            $admins = User::role('Administrador')->get();
            $adminData = [
                'appointments' => $allAppointments,
                'date' => $formattedDate,
            ];

            if ($admins->count() > 0) {
                foreach ($admins as $admin) {
                    \Illuminate\Support\Facades\Mail::send('emails.reports.daily-admin', $adminData, function ($message) use ($admin, $formattedDate) {
                        $message->to($admin->email)
                            ->subject("Reporte Diario de Citas - {$formattedDate}");
                    });
                    $this->info("Reporte enviado al administrador: {$admin->email}");
                }
            } else {
                $from = config('mail.from.address');
                \Illuminate\Support\Facades\Mail::send('emails.reports.daily-admin', $adminData, function ($message) use ($from, $formattedDate) {
                    $message->to($from)
                        ->subject("Reporte Diario de Citas - {$formattedDate}");
                });
                $this->info("Reporte enviado al correo de sistema.");
            }

            // 2. Enviar agenda a cada doctor
            $appointmentsByDoctor = $allAppointments->groupBy('doctor_id');

            foreach ($appointmentsByDoctor as $doctorId => $doctorAppointments) {
                $doctor = Doctor::find($doctorId);
                if ($doctor && $doctor->user) {
                    $doctorData = [
                        'appointments' => $doctorAppointments,
                        'doctor' => $doctor,
                        'date' => $formattedDate,
                    ];

                    \Illuminate\Support\Facades\Mail::send('emails.reports.daily-doctor', $doctorData, function ($message) use ($doctor, $formattedDate) {
                        $message->to($doctor->user->email)
                            ->subject("Agenda del Día - {$formattedDate}");
                    });
                    $this->info("Agenda enviada a: {$doctor->user->name} ({$doctor->user->email})");
                }
            }
        } catch (\Exception $e) {
            $this->error('Error en comando diario: ' . $e->getMessage());
            \Log::error('Error en comandos diarios de correo: ' . $e->getMessage());
        }

        $this->info('Fin del proceso de reportes diarios.');
    }
}
