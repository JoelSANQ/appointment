@php
    $errorGroups = [
        'antecedentes' => ['allergies', 'chronic_conditions', 'surgical_history', 'family_history'],
        'informacion-general' => ['blood_type_id', 'observations'],
        'contactos-emergencia' => ['emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship'],
    ];

    $initialTab = $initialTab ?? 'datos-personales';

    foreach ($errorGroups as $tabName => $fields) {
        if ($errors->hasAny($fields)) {
            $initialTab = $tabName;
            break;
        }
    }
@endphp

<x-admin-layout
    title="Editar | Medify"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Pacientes',
            'href' => route('admin.patients.index'),
        ],
        [
            'name' => 'Editar',
        ],
    ]">

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Encabezado con foto y acciones --}}
        <x-wire-card class="mb-4">
            <div class="lg:flex lg:justify-between lg:items-center">
                <div>
                    <div class="flex items-center">
                        <img src="{{ $patient->user->profile_photo_url }}" alt="{{ $patient->user->name }}"
                             class="w-20 h-20 rounded-full object-cover object-center">
                        <div class="ml-4">
                            <p class="text-2xl font-bold text-gray-900">{{ $patient->user->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3 mt-6 lg:mt-0">
                    <x-wire-button outline href="{{ route('admin.patients.index') }}">Volver</x-wire-button>
                    <x-wire-button type="submit">
                        <i class="fa-solid fa-check"></i>
                        Guardar Cambios
                    </x-wire-button>
                </div>
            </div>
        </x-wire-card>

        {{-- Tabs de navegación --}}
        <x-wire-card>
            <x-tabs :active="$initialTab">

                <x-slot name="header">
                    <x-tabs-link tab="datos-personales" :error="false">
                        <i class="fa-solid fa-user me-2"></i>
                        Datos Personales
                    </x-tabs-link>

                    <x-tabs-link
                        tab="antecedentes"
                        :error="$errors->hasAny($errorGroups['antecedentes'])"
                    >
                        <i class="fa-solid fa-file-lines me-2"></i>
                        Antecedentes
                    </x-tabs-link>

                    <x-tabs-link
                        tab="informacion-general"
                        :error="$errors->hasAny($errorGroups['informacion-general'])"
                    >
                        <i class="fa-solid fa-info me-2"></i>
                        Información General
                    </x-tabs-link>

                    <x-tabs-link
                        tab="contactos-emergencia"
                        :error="$errors->hasAny($errorGroups['contactos-emergencia'])"
                    >
                        <i class="fa-solid fa-heart me-2"></i>
                        Contacto de Emergencia
                    </x-tabs-link>
                </x-slot>

                {{-- Tab 1: Datos Personales --}}
                <x-tab-content tab="datos-personales">
                    <div class="bg-blue-100 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-user-cog text-blue-500 text-xl mt-1"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-blue-800">
                                        Edición de cuenta de usuario
                                    </h3>
                                    <p class="mt-1 text-sm text-blue-600">
                                        La <strong>información de acceso</strong> del paciente se muestra a continuación
                                        (Nombre, email y contraseña). Debe gestionarse desde la cuenta de usuario asociado.
                                    </p>
                                </div>
                            </div>

                            <div class="flex-shrink-0">
                                <x-wire-button primary sm href="{{ route('admin.users.edit', $patient->user_id) }}" target="_blank">
                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                    Editar cuenta de usuario
                                </x-wire-button>
                            </div>
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-2 gap-4">
                        <div>
                            <span class="text-gray-500 font-semibold ml-1">Telefono:</span>
                            <span class="text-gray-500 ml-1">{{ $patient->user->phone }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 font-semibold ml-1">Email:</span>
                            <span class="text-gray-500 ml-1">{{ $patient->user->email }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 font-semibold ml-1">Direccion:</span>
                            <span class="text-gray-500 ml-1">{{ $patient->user->address }}</span>
                        </div>
                    </div>
                </x-tab-content>

                {{-- Tab 2: Antecedentes --}}
                <x-tab-content tab="antecedentes">
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div>
                            <x-wire-textarea
                                label="Alergias conocidas"
                                name="allergies"
                                placeholder="Mariscos, penicilina, etc."
                                value="{{ old('allergies', $patient->allergies) }}"
                            />
                        </div>

                        <div>
                            <x-wire-textarea
                                label="Enfermedades cronicas"
                                name="chronic_conditions"
                                value="{{ old('chronic_conditions', $patient->chronic_conditions) }}"
                            />
                        </div>

                        <div>
                            <x-wire-textarea
                                label="Antecedentes familiares"
                                name="family_history"
                                value="{{ old('family_history', $patient->family_history) }}"
                            />
                        </div>

                        <div>
                            <x-wire-textarea
                                label="Antecedentes quirurgicos"
                                name="surgical_history"
                                value="{{ old('surgical_history', $patient->surgical_history) }}"
                            />
                        </div>
                    </div>
                </x-tab-content>

                {{-- Tab 3: Información General --}}
                <x-tab-content tab="informacion-general">
                    <div class="grid gap-4">
                        <div>
                            <x-wire-native-select label="Tipo de sangre" name="blood_type_id" class="mb-4">
                                <option value="">Selecciona un tipo de sangre</option>

                                @foreach($bloodTypes as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('blood_type_id', $patient->blood_type_id) == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </x-wire-native-select>
                        </div>

                        <x-wire-textarea
                            label="Observaciones"
                            name="observations"
                            value="{{ old('observations', $patient->observations) }}"
                        />
                    </div>
                </x-tab-content>

                {{-- Tab 4: Contacto de Emergencia --}}
                <x-tab-content tab="contactos-emergencia">
                    <div class="space-y-4">
                        <x-wire-input
                            label="Nombre de contacto"
                            placeholder="Nombre completo del contacto de emergencia"
                            name="emergency_contact_name"
                            value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                        />

                        @php
                            $emergencyPhone = old('emergency_contact_phone', $patient->emergency_contact_phone);

                            if ($emergencyPhone && preg_match('/^(\d{3})(\d{3})(\d{4})$/', $emergencyPhone, $matches)) {
                                $emergencyPhone = "({$matches[1]}) {$matches[2]}-{$matches[3]}";
                            }
                        @endphp

                        <x-wire-phone-input
                            label="Teléfono de contacto"
                            name="emergency_contact_phone"
                            mask="(999) 999-9999"
                            placeholder="(999) 999-9999"
                            value="{{ $emergencyPhone }}"
                        />

                        <x-wire-input
                            label="Relación con el contacto"
                            name="emergency_contact_relationship"
                            placeholder="Hermano, padre, madre, etc."
                            value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}"
                        />
                    </div>
                </x-tab-content>

            </x-tabs>
        </x-wire-card>
    </form>

</x-admin-layout>
