@props(['route', 'label'])

@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   class="px-6 py-2 block transition-all duration-150 rounded-r-lg
          {{ $isActive 
              ? 'bg-blue-800 font-semibold text-white' 
              : 'text-white hover:bg-blue-800 hover:pl-7' }}">
    {{ $label }}
</a>
