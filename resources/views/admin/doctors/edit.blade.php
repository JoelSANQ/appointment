<x-admin-layout
    title="Editar Doctor | Medify"
    :breadcrumbs="[
        ['name'=>'Dashboard','href'=>route('admin.dashboard')],
        ['name'=>'Doctores','href'=>route('admin.doctors.index')],
        ['name'=>'Editar']
    ]">

    <form method="POST" action="{{ route('admin.doctors.update', $doctor) }}">
        @csrf
        @method('PUT')

        <x-wire-card>
            {{-- Cabecera del Perfil (Avatar y Botones) --}}
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-100">
                <div class="flex items-center space-x-4">
                    {{-- Avatar circular con iniciales dinámicas --}}
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 text-blue-600 text-xl font-bold border border-blue-100">
                        {{ collect(explode(' ', $doctor->user->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('') }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $doctor->user->name }}</h2>
                        <p class="text-sm text-gray-500">Licencia: {{ $doctor->medical_license_number ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <x-wire-button href="{{ route('admin.doctors.index') }}" secondary label="Volver" />
                    <x-wire-button type="submit" blue icon="check" label="Guardar cambios" />
                </div>
            </div>

            {{-- Formulario de Edición --}}
            <div class="grid grid-cols-1 gap-6">
                
                {{-- Selección de Especialidad --}}
                <x-wire-native-select
                    label="Especialidad"
                    name="speciality_id"
                    :options="$specialities->pluck('name', 'id')"
                    :value="old('speciality_id', $doctor->speciality_id)"
                >
                    <option value="">Selecciona una especialidad</option>
                </x-wire-native-select>

                {{-- Número de licencia médica --}}
                <x-wire-input
                    label="Número de licencia médica"
                    name="medical_license_number"
                    :value="old('medical_license_number', $doctor->medical_license_number)"
                    placeholder="Ej. 6549876341654654"
                />

                {{-- Biografía  --}}
                <x-wire-textarea
                    label="Biografía"
                    name="biography"
                    placeholder="Escribe una breve descripción..."
                    rows="4"
                >{{ trim(old('biography', $doctor->biography)) }}</x-wire-textarea>

                <input type="hidden" name="user_id" value="{{ $doctor->user_id }}">
            </div>
        </x-wire-card>
    </form>

</x-admin-layout>