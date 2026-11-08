@props([
    'variant' => 'neutral',
    'size' => 'md',
    'appearance' => 'soft',
    'removable' => false,
])

@php
    if (! in_array($variant, ['primary', 'success', 'warning', 'danger', 'info', 'neutral'], true)) {
        throw new \InvalidArgumentException('Unsupported tag variant: ' . $variant);
    }
    if (! in_array($appearance, ['soft', 'solid', 'outline'], true)) {
        throw new \InvalidArgumentException('Tag appearance must be soft, solid, or outline.');
    }
    if (! in_array($size, ['sm', 'md', 'lg'], true)) {
        throw new \InvalidArgumentException('Tag size must be sm, md, or lg.');
    }
@endphp

<span {{ $attributes->class(['rai-tag', 'rai-tag--' . $variant, 'rai-tag--' . $appearance, 'rai-tag--' . $size]) }}>
    <span class="rai-tag__content">{{ $slot }}</span>
    @if ($removable)
        <button type="button" class="rai-tag__remove" aria-label="Remove {{ trim(strip_tags($slot)) }}" data-rai-tag-remove>
            <span aria-hidden="true">&times;</span>
        </button>
    @endif
</span>
