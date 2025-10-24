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
</x-admin-layout>
