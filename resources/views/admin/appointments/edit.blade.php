<x-admin-layout
    title="Editar Cita | Medify"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Citas', 'href' => route('admin.appointments.index')],
        ['name' => 'Editar Cita #' . $appointment->id],
    ]"
>

    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Card: Información de la Cita --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-800">
                    <i class="fa-solid fa-calendar-check text-blue-500 mr-2"></i>
                    Información de la Cita
                </h2>
            </div>

            <div class="p-6 space-y-6">
                {{-- Paciente y Doctor --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center gap-4 bg-blue-50/50 rounded-xl p-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold flex-shrink-0">
                            {{ strtoupper(substr($appointment->patient->user->name, 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Paciente</p>
                            <p class="text-sm font-bold text-gray-800 truncate">{{ $appointment->patient->user->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $appointment->patient->user->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-indigo-50/50 rounded-xl p-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-bold flex-shrink-0">
                            {{ strtoupper(substr($appointment->doctor->user->name, 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Doctor</p>
                            <p class="text-sm font-bold text-gray-800 truncate">{{ $appointment->doctor->user->name }}</p>
                            <p class="text-xs text-indigo-500 font-medium truncate">{{ $appointment->doctor->speciality->name ?? 'Medicina General' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Fecha y Hora --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Fecha</p>
                        <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($appointment->date)->translatedFormat('l') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Hora inicio</p>
                        <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Hora fin</p>
                        <p class="text-sm font-bold text-gray-800">{{ $appointment->end_time ? \Carbon\Carbon::parse($appointment->end_time)->format('H:i') : '--:--' }}</p>
                    </div>
                </div>

                {{-- Motivo --}}
                @if($appointment->reason)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Motivo de la cita</p>
                        <p class="text-sm text-gray-700">{{ $appointment->reason }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Card: Cambiar Estado --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-800">
                    <i class="fa-solid fa-arrow-right-arrow-left text-green-500 mr-2"></i>
                    Cambiar Estado
                </h2>
            </div>

            <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="flex flex-col md:flex-row md:items-center gap-6">
                    {{-- Estado actual --}}
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 mb-2">Estado actual:</p>
                        @php
                            $colors = [
                                'Programado' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'Completado' => 'bg-green-100 text-green-700 border-green-200',
                                'Cancelado' => 'bg-red-100 text-red-700 border-red-200',
                            ];
                            $color = $colors[$appointment->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                        @endphp
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold border {{ $color }}">
                            <i class="fa-solid fa-circle text-[6px] mr-2"></i>
                            {{ $appointment->status }}
                        </span>
                    </div>

                    {{-- Selector --}}
                    <div class="flex-1">
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Cambiar a:</label>
                        <select name="status" id="status" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all appearance-none cursor-pointer text-sm font-medium">
                            <option value="Programado" {{ $appointment->status == 'Programado' ? 'selected' : '' }}>
                                📅 Programado
                            </option>
                            <option value="Completado" {{ $appointment->status == 'Completado' ? 'selected' : '' }}>
                                ✅ Completado
                            </option>
                            <option value="Cancelado" {{ $appointment->status == 'Cancelado' ? 'selected' : '' }}>
                                ❌ Cancelado
                            </option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-2 border-t border-gray-100">
                    <button type="submit"
                            class="flex-1 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95">
                        <i class="fa-solid fa-save mr-2"></i>
                        Guardar cambios
                    </button>

                    <a href="{{ route('admin.appointments.index') }}"
                       class="flex-1 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold text-center hover:bg-gray-200 transition-all">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Volver
                    </a>
                </div>
            </form>
        </div>

    </div>

</x-admin-layout>
