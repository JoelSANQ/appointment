<?php

namespace App\Notifications;

use App\Models\Appointment;
use App\Notifications\Channels\WhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ConsultationCompletedWhatsApp extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment->load(['consultation.prescriptionItems', 'doctor.user']);
    }

    public function via($notifiable)
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        $patientName = $this->appointment->patient->name;
        $doctorName = $this->appointment->doctor->user->name;
        $diagnosis = $this->appointment->consultation->diagnosis;
        
        $message = "Hola {$patientName}, tu consulta con el Dr. {$doctorName} ha finalizado.\n\n";
        $message .= "*Diagnóstico:* {$diagnosis}\n\n";
        
        $items = $this->appointment->consultation->prescriptionItems;
        if ($items->count() > 0) {
            $message .= "*Receta Médica:*\n";
            foreach ($items as $item) {
                $message .= "- {$item->medicine_name}: {$item->dosage} ({$item->frequency_duration})\n";
            }
        }
        
        $message .= "\n¡Cuidate mucho!";
        
        return $message;
    }
}
