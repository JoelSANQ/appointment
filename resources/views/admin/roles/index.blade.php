<<<<<<< HEAD
<x-admin-layout
    title="Roles | HouseMD"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Roles',
        ],
    ]"
>

    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.roles.create') }}">
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>

    @livewire('admin.data-tables.role-table')

=======
<x-admin-layout title="Roles | Simify" :breadcrumb="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
    ],
]">
    @livewire('admin.datatables.role-table')
>>>>>>> parent of 19a4104 (feat(roles): add top "Nuevo" button in roles page and integrate it into admin layout slot)
</x-admin-layout>
