@props(['tab', 'error' => false])
<div>
    <div x-show="tab === '{{ $tab }}'"   >
        {{ $slot }}
    </div>
</div>