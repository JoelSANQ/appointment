<div class="flex gap-1">

<x-wire-button xs
href="{{ route('admin.doctors.show',$doctor) }}">
<i class="fa-solid fa-eye"></i>
</x-wire-button>

<x-wire-button xs blue
href="{{ route('admin.doctors.edit',$doctor) }}">
<i class="fa-solid fa-pen"></i>
</x-wire-button>

<form method="POST"
action="{{ route('admin.doctors.destroy',$doctor) }}">
@csrf
@method('DELETE')

<x-wire-button xs red type="submit">
<i class="fa-solid fa-trash"></i>
</x-wire-button>
</form>

</div>