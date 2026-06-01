@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#f2b84b] text-sm font-semibold leading-5 text-[#1f241f] focus:outline-none focus:border-[#7f8f58] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-[#626a5d] hover:text-[#1f241f] hover:border-[#aeb99c] focus:outline-none focus:text-[#1f241f] focus:border-[#aeb99c] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
