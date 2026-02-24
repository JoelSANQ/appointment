<x-admin-layout
    title="Doctores | Medify"
    :breadcrumbs="[
        ['name'=>'Dashboard','href'=>route('admin.dashboard')],
        ['name'=>'Doctores']
    ]">

    <x-wire-card>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Listado de Doctores</h2>
        </div>

        <div class="divide-y">
            @foreach($doctors as $doctor)
                <div class="flex justify-between items-center py-3">
                    <div class="flex items-center gap-4">
                        <img 
                            src="{{ $doctor->user->profile_photo_url }}" 
                            alt="Foto de {{ $doctor->user->name }}" 
                            class="w-12 h-12 rounded-full object-cover"
                        >
                        <div>
                            <p class="font-semibold">{{ $doctor->user->name }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $doctor->speciality->name ?? 'Sin especialidad' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <x-wire-button xs href="{{ route('admin.doctors.show', $doctor) }}">
                            Ver
                        </x-wire-button>

                        <x-wire-button xs blue href="{{ route('admin.doctors.edit', $doctor) }}">
                            Editar
                        </x-wire-button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $doctors->links() }}
        </div>
    </x-wire-card>
</x-admin-layout>