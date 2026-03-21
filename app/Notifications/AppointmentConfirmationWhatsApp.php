<?php

namespace App\Notifications;

use App\Models\Appointment;
use App\Notifications\Channels\WhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AppointmentConfirmationWhatsApp extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        $date = Carbon::parse($this->appointment->date)->format('d/m/Y');
        $time = Carbon::parse($this->appointment->time)->format('h:i A');
        $doctor = $this->appointment->doctor->user->name;
        
        return "Hola {$this->appointment->patient->name}, tu cita ha sido confirmada para el día *{$date}* a las *{$time}* con el Dr. {$doctor}.";
    }
}
