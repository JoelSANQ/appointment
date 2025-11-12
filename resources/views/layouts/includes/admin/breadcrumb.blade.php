<<<<<<< HEAD
{{-- Verifica si hay un elemento en breadcrumb --}}
@if (count($breadcrumbs))
    {{-- Margin botton o margen inferior --}}
    <nav class="mb-2 block">
        <ol class="flex flex-wrap text-slate-700 text-sm">
            @foreach ($breadcrumbs as $item)
                <li class="flex items-center">
                    @unless ($loop->first)
                        <span class="px-2 text-gray-400">/</span>
                    @endunless

                    {{-- Revisar si existe una llave llamada 'href' --}}
                    @isset($item['href'])
                        <a href="{{ $item['href'] }}" class="opacity-60 hover:opacity-100">
                            {{ $item['name'] }}
                        </a>

                    @else
                        {{ $item['name'] }}
                    @endisset

                </li>
            @endforeach
        </ol>
        <!-- El ultimo item aparece resaltado -->
        @if (count($breadcrumbs) > 1)
            <h6 class="font-bold mt-2">
                {{ end($breadcrumbs)['name'] }}
            </h6>

=======
@if(isset($breadcrumbs) && count($breadcrumbs) > 0)
    <nav class="mb-4 block w-full">
        <ol class="flex flex-wrap items-center text-gray-700 text-sm mb-2">
            @foreach($breadcrumbs as $item)
                <li class="flex items-center">
                    @unless($loop->first)
                        {{--padding eje x--}}
                        <span class="px-2 text-gray-400">/</span>
                    @endunless

                    @isset($item['href'])
                        {{--si existe href muestralo--}}
                        <a href="{{$item['href']}}" class="text-blue-600 hover:text-blue-800 hover:underline transition">{{$item['name']}}</a>
                    @else
                        <span class="text-gray-900 font-medium">{{$item['name']}}</span>
                    @endisset
                </li>
            @endforeach
        </ol>
        @if(count($breadcrumbs) > 1)
            <h1 class="font-bold text-2xl text-gray-900">
                {{end($breadcrumbs)['name']}}
            </h1>
>>>>>>> 463f42e (feat(roles): complete CRUD workflow with edit restrictions and delete confirmation)
        @endif
    </nav>
@endif
