<button {{ $attributes->merge(['type' => 'submit', 'class' => 'action-dark text-xs uppercase tracking-normal']) }}>
    {{ $slot }}
</button>
