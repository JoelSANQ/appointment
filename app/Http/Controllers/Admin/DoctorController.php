<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Speciality;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::latest()->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $users = User::all();
        $specialities = Speciality::all();
        return view('admin.doctors.create', compact('users', 'specialities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'speciality_id' => 'required|exists:specialities,id',
            'medical_license_number' => 'required|string|max:255',
            'biography' => 'nullable|string',
        ]);

        Doctor::create($request->all());

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor creado');
    }

    public function show(Doctor $doctor)
    {
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $users = User::all();
        $specialities = Speciality::all();
        return view('admin.doctors.edit', compact('doctor', 'users', 'specialities'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'speciality_id' => 'required|exists:specialities,id', 
            'medical_license_number' => 'required',
            'biography' => 'nullable',
        ]);

        $doctor->update($request->all());

        return redirect()->route('admin.doctors.index')->with('success', 'Actualizado correctamente');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return back()->with('success', 'Doctor eliminado');
    }
}