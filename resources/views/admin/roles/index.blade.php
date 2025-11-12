<<<<<<< HEAD
<x-admin-layout title="Roles | Medify" :breadcrumbs="[
        [
          'name' => 'Dashboard',
          'href' => route('admin.dashboard')
        ],
        [
          'name' => 'Roles'
        ],
    ]">
=======
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

>>>>>>> 463f42e (feat(roles): complete CRUD workflow with edit restrictions and delete confirmation)
    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.roles.create') }}">
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>jeded

<<<<<<< HEAD
    @livewire('admin.datatables.role-table')
=======
    @livewire('admin.data-tables.role-table')
>>>>>>> 463f42e (feat(roles): complete CRUD workflow with edit restrictions and delete confirmation)

</x-admin-layout>
