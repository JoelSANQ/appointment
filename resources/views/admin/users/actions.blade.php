{{-- resources/views/admin/users/actions.blade.php --}}
<div class="flex items-center gap-2">
    {{-- Botón editar --}}
    <x-wire-button href="{{ route('admin.users.edit', $user) }}" blue xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    {{-- Botón eliminar --}}
    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        <x-wire-button type="submit" red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>