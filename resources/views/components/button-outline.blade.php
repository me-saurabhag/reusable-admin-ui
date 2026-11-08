@props([
    'type' => 'button',
    'size' => 'md',
    'disabled' => false,
])

<button
    {{ $attributes->class([
        'btn',
        'btn-outline-secondary',
        'rai-btn',
        'rai-btn-outline',
        'rai-btn--sm' => $size === 'sm',
        'rai-btn--lg' => $size === 'lg',
    ])->merge(['type' => $type]) }}
    @disabled($disabled)
>
    {{ $slot }}
</button>
