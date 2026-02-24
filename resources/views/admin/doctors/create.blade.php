<x-admin-layout
title="Crear Doctor | Medify"
:breadcrumbs="[
['name'=>'Dashboard','href'=>route('admin.dashboard')],
['name'=>'Doctores','href'=>route('admin.doctors.index')],
['name'=>'Crear']
]">

<form method="POST" action="{{ route('admin.doctors.store') }}">
@csrf

<x-wire-card>

<div class="space-y-5">

<x-select
label="Usuario"
name="user_id"
:options="$users->pluck('name','id')"
/>

<x-select
label="Especialidad"
name="speciality_id"
:options="$specialities->pluck('name','id')"
/>

<x-input label="Licencia médica" name="medical_license_number"/>

<x-textarea label="Biografía" name="biography"/>

<div class="flex justify-end pt-4">
<x-wire-button type="submit" blue>
Crear Doctor
</x-wire-button>
</div>

</div>

</x-wire-card>

</form>
</x-admin-layout>