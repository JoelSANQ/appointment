<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Speciality;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->latest()
            ->paginate(10);
            
        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specialities = Speciality::all();
        $patients = Patient::with('user')->get();
        return view('admin.appointments.create', compact('specialities', 'patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);

        $carbonDate = Carbon::parse($request->date);
        $dayOfWeek = $carbonDate->dayOfWeek; // 0 (Domingo) - 6 (Sábado)

        // 1. Verificar si el doctor trabaja ese día y hora (Disponibilidad)
        $workDay = \App\Models\WorkDay::where('doctor_id', $request->doctor_id)
            ->where('day', $dayOfWeek)
            ->where('active', true)
            ->first();

        if (!$workDay || !in_array($request->time, $workDay->slots)) {
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Doctor no disponible',
                'text' => 'El doctor no tiene este horario marcado como disponible en su calendario.',
            ])->withInput();
        }

        // 2. Verificar conflicto del Doctor (Cita ya existente)
        $doctorConflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->where('status', '!=', 'Cancelado')
            ->exists();

        if ($doctorConflict) {
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Conflicto del Doctor',
                'text' => 'El doctor ya tiene una cita programada para esta fecha y hora.',
            ])->withInput();
        }

        // 3. Verificar conflicto del Paciente (No puede tener 2 citas a la misma hora)
        $patientConflict = Appointment::where('patient_id', $request->patient_id)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->where('status', '!=', 'Cancelado')
            ->exists();

        if ($patientConflict) {
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Conflicto del Paciente',
                'text' => 'Este paciente ya tiene otra cita agendada exactamente a la misma hora.',
            ])->withInput();
        }

        // Calcular hora fin (ejemplo: 30 minutos después)
        $startTime = Carbon::parse($request->time);
        $endTime = $startTime->copy()->addMinutes(30)->format('H:i');

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'time' => $request->time,
            'end_time' => $endTime,
            'status' => 'Programado',
            'reason' => $request->reason,
        ]);

        // Enviar confirmación por WhatsApp
        $appointment->patient->notify(new \App\Notifications\AppointmentConfirmationWhatsApp($appointment));

        // Cargar relaciones necesarias para el correo y PDF
        $appointment->load(['patient.user', 'doctor.user', 'doctor.speciality']);

        // Generar PDF del comprobante
        $pdf = Pdf::loadView('emails.appointments.receipt-pdf', ['appointment' => $appointment]);
        $pdfContent = $pdf->output();

        // Enviar correo con Laravel Mail
        try {
            $data = ['appointment' => $appointment];
            $pdfFilename = 'Comprobante_Cita.pdf';

            // Correo al paciente y al doctor
            $recipients = [
                $appointment->patient->user->email => 'Confirmación de Cita Médica - ' . $appointment->date,
                $appointment->doctor->user->email  => 'Nueva Cita Asignada - ' . $appointment->date,
            ];

            foreach ($recipients as $email => $subject) {
                \Illuminate\Support\Facades\Mail::send('emails.appointments.receipt-body', $data, function ($message) use ($email, $subject, $pdfContent, $pdfFilename) {
                    $message->to($email)
                        ->subject($subject)
                        ->attachData($pdfContent, $pdfFilename, [
                            'mime' => 'application/pdf',
                        ]);
                });
            }
        } catch (\Exception $e) {
            \Log::error('Error enviando correos con Laravel Mail: ' . $e->getMessage());
        }

        return redirect()->route('admin.appointments.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Cita programada',
            'text' => 'La cita se ha registrado respetando la disponibilidad y sin conflictos.',
        ]);
    }

    /**
     * API para buscar doctores disponibles en tiempo real.
     */
    public function getAvailableDoctors(Request $request)
    {
        $date = $request->date;
        $specialityId = $request->speciality_id;

        if (!$date) {
            return response()->json([]);
        }

        $dayOfWeek = Carbon::parse($date)->dayOfWeek;

        $doctors = Doctor::with(['user', 'speciality', 'workDays' => function($q) use ($dayOfWeek) {
                $q->where('day', $dayOfWeek)->where('active', true);
            }, 'appointments' => function($q) use ($date) {
                $q->where('date', $date)->where('status', '!=', 'Cancelado');
            }])
            ->when($specialityId, function($q) use ($specialityId) {
                $q->where('speciality_id', $specialityId);
            })
            ->get();

        return response()->json($doctors);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $specialities = Speciality::all();
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        return view('admin.appointments.edit', compact('appointment', 'specialities', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $oldStatus = $appointment->status;
        $appointment->update([
            'status' => $request->status,
        ]);

        // Si se cancela la cita, notificar al paciente
        if ($oldStatus != 'Cancelado' && $request->status == 'Cancelado') {
            try {
                $appointment->patient->notify(new \App\Notifications\AppointmentCancelledWhatsApp($appointment));
            } catch (\Exception $e) {
                \Log::error("Error enviando cancelación WhatsApp: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.appointments.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Cita actualizada',
            'text' => 'El estado de la cita ha sido actualizado ' . ($request->status == 'Cancelado' ? 'y se ha notificado al paciente.' : '.'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Cita eliminada',
            'text' => 'La cita ha sido eliminada del sistema.',
        ]);
    }
    /**
     * Enviar recordatorio manual por WhatsApp.
     */
    public function sendReminder(Appointment $appointment)
    {
        if (!$appointment->patient->phone_number) {
            return back()->with('swal', [
                'icon' => 'warning',
                'title' => 'Sin teléfono',
                'text' => 'El paciente no tiene un número de teléfono registrado.',
            ]);
        }

        $appointment->patient->notify(new \App\Notifications\AppointmentConfirmationWhatsApp($appointment));

        return back()->with('swal', [
            'icon' => 'success',
            'title' => 'Recordatorio enviado',
            'text' => 'Se ha enviado la confirmación por WhatsApp exitosamente.',
        ]);
    }

    /**
     * Mostrar vista de consulta médica.
     */
    public function consultation(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'patient.bloodType', 'consultation.prescriptionItems', 'doctor.user']);
        
        // Obtener historial de consultas anteriores completadas
        $previousAppointments = Appointment::where('patient_id', $appointment->patient_id)
            ->where('id', '!=', $appointment->id)
            ->where('status', 'Completado')
            ->with(['consultation', 'doctor.user'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        return view('admin.appointments.consultation', compact('appointment', 'previousAppointments'));
    }

    /**
     * Guardar datos de la consulta y receta.
     */
    public function storeConsultation(Request $request, Appointment $appointment)
    {
        $request->validate([
            'diagnosis' => 'required',
            'treatment' => 'required',
            'medicines' => 'array',
            'medicines.*' => 'nullable|string',
            'dosages' => 'array',
            'frequencies' => 'array',
        ]);

        // Crear o actualizar la consulta
        $consultation = \App\Models\Consultation::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'diagnosis' => $request->diagnosis,
                'treatment' => $request->treatment,
                'notes' => $request->notes,
            ]
        );

        // Guardar ítems de la receta
        $consultation->prescriptionItems()->delete(); // Limpiar anteriores si existen
        
        if ($request->has('medicines')) {
            foreach ($request->medicines as $index => $medicine) {
                if ($medicine) {
                    $consultation->prescriptionItems()->create([
                        'medicine_name' => $medicine,
                        'dosage' => $request->dosages[$index] ?? '',
                        'frequency_duration' => $request->frequencies[$index] ?? '',
                    ]);
                }
            }
        }

        // Marcar cita como completada si se guarda la consulta
        $appointment->update(['status' => 'Completado']);

        // Enviar Receta por WhatsApp
        try {
            $appointment->patient->notify(new \App\Notifications\ConsultationCompletedWhatsApp($appointment));
        } catch (\Exception $e) {
            // No bloqueamos el flujo si falla el envío de notificación
            \Log::error("Error enviando receta WhatsApp: " . $e->getMessage());
        }

        return redirect()->route('admin.appointments.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Consulta guardada',
            'text' => 'La información médica y receta han sido registradas y enviadas al paciente.',
        ]);
    }
}
