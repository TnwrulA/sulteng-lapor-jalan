@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#f2b84b] text-start text-base font-semibold text-[#1f241f] bg-[#f4f6ed] focus:outline-none focus:text-[#1f241f] focus:bg-[#eef1e7] focus:border-[#7f8f58] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-[#626a5d] hover:text-[#1f241f] hover:bg-[#f4f6ed] hover:border-[#aeb99c] focus:outline-none focus:text-[#1f241f] focus:bg-[#f4f6ed] focus:border-[#aeb99c] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
