<x-admin-layout
    title="Citas Médicas | Medify"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Citas médicas',
        ],
    ]"
>

    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.appointments.create') }}">
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>

    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100">
        <div class="p-6 border-b border-gray-200 flex flex-wrap justify-between items-center gap-4">
            <h2 class="text-xl font-bold text-gray-800">Citas</h2>
            
            <div class="flex items-center gap-3">
                <div class="relative">
                    <input type="text" placeholder="Buscar..." 
                           class="pl-10 pr-4 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none border-gray-200">
                    <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">PACIENTE</th>
                        <th class="px-6 py-4">DOCTOR</th>
                        <th class="px-6 py-4">FECHA</th>
                        <th class="px-6 py-4">HORA</th>
                        <th class="px-6 py-4">HORA FIN</th>
                        <th class="px-6 py-4">ESTADO</th>
                        <th class="px-6 py-4 text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($appointments as $appointment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $appointment->id }}</td>
                            <td class="px-6 py-4">{{ $appointment->patient->user->name }}</td>
                            <td class="px-6 py-4 italic">{{ $appointment->doctor->user->name }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 font-medium text-gray-700">{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $appointment->end_time ? \Carbon\Carbon::parse($appointment->end_time)->format('H:i') : '--:--' }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $colors = [
                                        'Programado' => 'bg-blue-100 text-blue-700',
                                        'Completado' => 'bg-green-100 text-green-700',
                                        'Cancelado' => 'bg-red-100 text-red-700',
                                    ];
                                    $color = $colors[$appointment->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $color }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    {{-- Botón de Consulta --}}
                                    <a href="{{ route('admin.appointments.consultation', $appointment) }}" 
                                       title="Atender consulta"
                                       class="p-1.5 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition-all shadow-sm">
                                        <i class="fa-solid fa-stethoscope text-xs"></i>
                                    </a>

                                    {{-- Botón de Recordatorio WhatsApp --}}
                                    <form action="{{ route('admin.appointments.send-reminder', $appointment) }}" method="POST" class="inline shadow-sm">
                                        @csrf
                                        <button type="submit" 
                                               title="Enviar recordatorio WhatsApp"
                                               class="p-1.5 bg-green-500 text-white rounded hover:bg-green-600 transition-all">
                                            <i class="fa-brands fa-whatsapp text-xs"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                                       title="Editar cita"
                                       class="p-1.5 bg-blue-500 text-white rounded hover:bg-blue-600 transition-all shadow-sm">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>

                                    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Eliminar cita" class="p-1.5 bg-red-600 text-white rounded hover:bg-red-700 transition-all shadow-sm">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-400 italic">
                                No se encontraron citas médicas programadas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $appointments->links() }}
        </div>
    </div>

</x-admin-layout>
