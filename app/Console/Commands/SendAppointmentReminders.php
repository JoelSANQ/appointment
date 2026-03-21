<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios de WhatsApp a los pacientes con citas para mañana.';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $whatsapp)
    {
        $tomorrow = Carbon::tomorrow()->toDateString();
        
        $appointments = Appointment::where('date', $tomorrow)
            ->where('status', 'Programado')
            ->with(['patient', 'doctor.user'])
            ->get();

        $this->info("Encontradas {$appointments->count()} citas para mañana.");

        foreach ($appointments as $appointment) {
            $time = Carbon::parse($appointment->time)->format('h:i A');
            $date = Carbon::parse($appointment->date)->format('d/m'); // Ejemplo: 12/01
            
            // Usamos plantilla de Twilio (variables 1 y 2)
            $result = $whatsapp->sendTemplateMessage($appointment->patient->phone_number, [
                "1" => $date,
                "2" => $time
            ]);
            
            if ($result['success']) {
                $this->info("✔ Recordatorio enviado a {$appointment->patient->name} ({$appointment->patient->phone_number})");
            } else {
                $this->error("✘ Error enviando a {$appointment->patient->name}: " . ($result['message'] ?? 'Error desconocido'));
            }
        }

        $this->info('Todos los recordatorios han sido enviados.');
    }
}
