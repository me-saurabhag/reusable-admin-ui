@props([
    'variant' => 'neutral',
    'size' => 'md',
    'appearance' => 'soft',
    'dot' => false,
])

@php
    if (! in_array($variant, ['primary', 'success', 'warning', 'danger', 'info', 'neutral'], true)) {
        throw new \InvalidArgumentException('Unsupported pill variant: ' . $variant);
    }
    if (! in_array($appearance, ['soft', 'solid', 'outline'], true)) {
        throw new \InvalidArgumentException('Pill appearance must be soft, solid, or outline.');
    }
    if (! in_array($size, ['sm', 'md', 'lg'], true)) {
        throw new \InvalidArgumentException('Pill size must be sm, md, or lg.');
    }
@endphp

<span {{ $attributes->class(['rai-pill', 'rai-pill--' . $variant, 'rai-pill--' . $appearance, 'rai-pill--' . $size, 'rai-pill--dot' => $dot]) }}>
    {{ $slot }}
</span>
