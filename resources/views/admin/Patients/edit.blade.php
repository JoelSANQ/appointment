<x-admin-layout
    title="Editar Paciente | Medify"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Pacientes', 'href' => route('admin.patients.index')],
        ['name' => 'Editar']
    ]">

    <form method="POST" action="{{ route('admin.patients.update', $patient) }}">
        @csrf
        @method('PUT')

        <x-wire-card>
            {{-- Cabecera del Perfil --}}
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-100">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 text-indigo-600 text-xl font-bold border border-indigo-100">
                        {{ collect(explode(' ', $patient->user->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('') }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $patient->user->name }}</h2>
                        <p class="text-sm text-gray-500">DNI: {{ $patient->user->id_numero ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <x-wire-button href="{{ route('admin.patients.index') }}" secondary label="Volver" />
                    <x-wire-button type="submit" blue icon="check" label="Guardar cambios" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Sección: Información Médica --}}
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-700 border-l-4 border-indigo-500 pl-3">Información Médica</h3>
                    
                    <x-wire-native-select
                        label="Tipo de Sangre"
                        name="blood_type_id"
                        :options="$bloodTypes"
                        :value="old('blood_type_id', $patient->blood_type_id)"
                    >
                        <option value="">Selecciona tipo de sangre</option>
                    </x-wire-native-select>

                    <x-wire-textarea
                        label="Alergias"
                        name="allergies"
                        placeholder="Lista de alergias conocidas..."
                        rows="3"
                    >{{ old('allergies', $patient->allergies) }}</x-wire-textarea>

                    <x-wire-textarea
                        label="Enfermedades Crónicas"
                        name="chronic_conditions"
                        placeholder="Diabetes, Hipertensión, etc..."
                        rows="3"
                    >{{ old('chronic_conditions', $patient->chronic_conditions) }}</x-wire-textarea>

                    <x-wire-textarea
                        label="Antecedentes Quirúrgicos"
                        name="surgical_history"
                        placeholder="Cirugías previas..."
                        rows="3"
                    >{{ old('surgical_history', $patient->surgical_history) }}</x-wire-textarea>
                </div>

                {{-- Sección: Contacto de Emergencia --}}
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-700 border-l-4 border-red-500 pl-3">Contacto de Emergencia</h3>
                    
                    <x-wire-input
                        label="Nombre del contacto"
                        name="emergency_contact_name"
                        :value="old('emergency_contact_name', $patient->emergency_contact_name)"
                    />

                    <x-wire-input
                        label="Teléfono del contacto"
                        name="emergency_contact_phone"
                        :value="old('emergency_contact_phone', $patient->emergency_contact_phone)"
                    />

                    <x-wire-input
                        label="Parentesco / Relación"
                        name="emergency_contact_relationship"
                        placeholder="Padre, Madre, Esposo(a)..."
                        :value="old('emergency_contact_relationship', $patient->emergency_contact_relationship)"
                    />

                    <div class="pt-4">
                        <x-wire-textarea
                            label="Observaciones adicionales"
                            name="observations"
                            rows="4"
                        >{{ old('observations', $patient->observations) }}</x-wire-textarea>
                    </div>
                </div>

            </div>
        </x-wire-card>
    </form>

</x-admin-layout>