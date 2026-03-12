<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WorkDay;
use App\Models\Doctor;

class ScheduleController extends Controller
{
    public function edit(Doctor $doctor)
    {
        $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        
        // Obtener horarios actuales
        $work_days = WorkDay::where('doctor_id', $doctor->id)->get();
        
        // En caso de que no existan, crear una colección vacía preparada
        if ($work_days->isEmpty()) {
            $work_days = collect();
            for ($i=0; $i<7; $i++) {
                $work_days->push(new WorkDay(['day' => $i, 'active' => false, 'slots' => []]));
            }
        }

        return view('admin.schedule.edit', compact('days', 'work_days', 'doctor'));
    }

    public function store(Request $request, Doctor $doctor)
    {
        $active_days = $request->input('active', []);
        $slots_data = $request->input('slots', []);

        foreach (range(0, 6) as $day_index) {
            WorkDay::updateOrCreate(
                [
                    'doctor_id' => $doctor->id,
                    'day' => $day_index,
                ],
                [
                    'active' => in_array($day_index, $active_days),
                    'slots' => $slots_data[$day_index] ?? [],
                ]
            );
        }

        return redirect()->route('admin.doctors.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Horario guardado',
            'text' => "La disponibilidad de {$doctor->user->name} ha sido actualizada correctamente.",
        ]);
    }
}
