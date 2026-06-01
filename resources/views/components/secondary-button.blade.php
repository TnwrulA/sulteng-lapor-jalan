<button {{ $attributes->merge(['type' => 'button', 'class' => 'action-muted text-xs uppercase tracking-normal disabled:opacity-25']) }}>
    {{ $slot }}
</button>
