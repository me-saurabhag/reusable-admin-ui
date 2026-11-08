@props([
    'type' => 'button',
    'size' => 'md',
    'disabled' => false,
])

<button
    {{ $attributes->class([
        'btn',
        'btn-primary',
        'rai-btn',
        'rai-btn-primary',
        'rai-btn--sm' => $size === 'sm',
        'rai-btn--lg' => $size === 'lg',
    ])->merge(['type' => $type]) }}
    @disabled($disabled)
>
    {{ $slot }}
</button>
