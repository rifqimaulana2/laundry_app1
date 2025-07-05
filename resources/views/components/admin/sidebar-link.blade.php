@props(['route', 'label'])

@php
    $isActive = request()->routeIs($route) ? 'bg-blue-800 font-semibold' : '';
@endphp

<a href="{{ route($route) }}"
   class="px-6 py-2 block hover:bg-blue-800 {{ $isActive }}">
    {{ $label }}
</a>
