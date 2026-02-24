<x-admin-layout
title="Detalle Doctor | Medify"
:breadcrumbs="[
['name'=>'Dashboard','href'=>route('admin.dashboard')],
['name'=>'Doctores','href'=>route('admin.doctors.index')],
['name'=>$doctor->user->name]
]">

<x-wire-card>

<div class="flex items-center gap-4 mb-6">

<img src="{{ $doctor->user->profile_photo_url }}"
class="w-20 h-20 rounded-full object-cover">

<div>
<p class="text-xl font-bold">{{ $doctor->user->name }}</p>
<p class="text-gray-500">
Licencia: {{ $doctor->medical_license_number ?? 'N/A' }}
</p>
</div>

</div>

<div class="grid lg:grid-cols-2 gap-6">

<div>
<p class="text-sm text-gray-500">Especialidad</p>
<p class="font-semibold">
{{ $doctor->speciality->name ?? 'Sin especialidad' }}
</p>
</div>

<div>
<p class="text-sm text-gray-500">Email</p>
<p class="font-semibold">
{{ $doctor->user->email }}
</p>
</div>

<div class="lg:col-span-2">
<p class="text-sm text-gray-500">Biografía</p>
<p>{{ $doctor->biography ?? 'Sin información' }}</p>
</div>

</div>

</x-wire-card>

<div class="flex justify-end mt-4 gap-2">

<x-wire-button flat
href="{{ route('admin.doctors.index') }}">
Volver
</x-wire-button>
<x-wire-button xs blue href="{{ route('admin.doctors.edit', $doctor->id) }}">
    Editar
</x-wire-button>

</div>

</x-admin-layout>