@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#ff5e00] text-sm font-semibold leading-5 text-[#1a1e1b] focus:outline-none focus:border-[#ff5e00] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-[#1a1e1b] hover:border-[#ff5e00]/40 focus:outline-none focus:text-[#1a1e1b] focus:border-[#ff5e00]/40 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
