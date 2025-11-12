@props([
<<<<<<< HEAD
    'title' =>  config('app.name', 'Laravel'),
    'breadcrumbs' => []])

    <!DOCTYPE html>
=======
    'title' => config('app.name', 'Laravel'),
    'breadcrumbs' => []
])

<!DOCTYPE html>
>>>>>>> 463f42e (feat(roles): complete CRUD workflow with edit restrictions and delete confirmation)
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<<<<<<< HEAD
    <script src="https://kit.fontawesome.com/e9e74fca35.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- WireUI --}}
    <wireui:scripts />

    <!-- Styles -->
=======
    <script src="https://kit.fontawesome.com/9161014f5f.js" crossorigin="anonymous"></script>

    <!-- Livewire Styles -->
>>>>>>> 463f42e (feat(roles): complete CRUD workflow with edit restrictions and delete confirmation)
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">

<<<<<<< HEAD
@include('layouts.includes.admin.navigation')

@include('layouts.includes.admin.sidebar')

<div class="p-4 sm:ml-64">
    <!-- Margin top 14px -->
    <div class="mt-14 flex items-center justify-between w-full" ></div>
    <div class="container mx-auto">
        @include('layouts.includes.admin.breadcrumb')
    </div>
    {{ $slot }}
</div>
@stack('modals')

@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

@if (@session('swal'))
    <script>
        Swal.fire(@json('swal'));
    </script>
@endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


=======
    {{-- Navegación y barra lateral --}}
    @include('layouts.includes.admin.navigation')
    @include('layouts.includes.admin.sidebar')

    <div class="p-4 sm:ml-64">
        {{-- margen superior para evitar que la barra fija tape el contenido --}}
        <div class="pt-20 pb-4 flex items-start justify-between">
            {{-- se intenta cargar breadcrumb desde includes/admin primero --}}
            @includeFirst(
                ['layouts.includes.admin.breadcrumb', 'layouts.includes.breadcrumb'],
                ['breadcrumbs' => $breadcrumbs ?? []]
            )

            @isset($action)
                <div class="flex-shrink-0">
                    {{ $action }}
                </div>
            @endisset
        </div>

        {{ $slot }}
    </div>

    @stack('modals')

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    {{-- Alertas SweetAlert basadas en sesión --}}
    @if(session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif

    {{-- Confirmación al eliminar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.delete-form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción no se puede revertir",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
>>>>>>> 463f42e (feat(roles): complete CRUD workflow with edit restrictions and delete confirmation)
</body>
</html>
