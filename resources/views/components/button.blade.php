@props([
    'type' => 'button',
    'variant' => 'primary',
    'appearance' => 'solid',
    'size' => 'md',
    'rounded' => false,
    'pill' => false,
    'square' => false,
    'outlineWidth' => 'normal',
    'block' => false,
    'disabled' => false,
    'loading' => false,
    'm' => null,
    'mt' => null,
    'mb' => null,
    'ms' => null,
    'me' => null,
    'mx' => null,
    'my' => null,
])

@php

    $spacingScale = ['0', '1', '2', '3', '4', '5', '6', '8', '10', '12', '16'];
    $spacingProps = ['m' => 'm', 'mt' => 'mt', 'mb' => 'mb', 'ms' => 'ms', 'me' => 'me', 'mx' => 'mx', 'my' => 'my'];
    $spacingClasses = [];

    foreach ($spacingProps as $prop => $prefix) {
        $spacingValue = $$prop ?? null;
        if ($spacingValue !== null && $spacingValue !== '') {
            $spacingValue = (string) $spacingValue;
            $valid = in_array($spacingValue, $spacingScale, true)
                || (in_array($prop, ['mx', 'ms', 'me'], true) && $spacingValue === 'auto');
            if (! $valid) {
                throw new \InvalidArgumentException("Invalid {$prop} spacing value. Use 0, 1, 2, 3, 4, 5, 6, 8, 10, 12, 16" . (in_array($prop, ['mx', 'ms', 'me'], true) ? ', or auto.' : '.'));
            }
            $spacingClasses[] = 'rai-' . $prefix . '-' . $spacingValue;
        }
    }

    $variants = ['primary', 'secondary', 'success', 'warning', 'danger', 'info', 'light', 'dark', 'outline', 'ghost'];
    $appearances = ['solid', 'outline', 'soft', 'ghost', 'link', 'gradient'];
    $sizes = ['xs', 'sm', 'md', 'lg'];
    $outlineWidths = ['normal', 'bold'];

    if (! in_array($variant, $variants, true)) {
        throw new \InvalidArgumentException('Unsupported button variant: ' . $variant);
    }

    if (! in_array($appearance, $appearances, true)) {
        throw new \InvalidArgumentException('Unsupported button appearance: ' . $appearance);
    }

    if (! in_array($outlineWidth, $outlineWidths, true)) {
        throw new \InvalidArgumentException('Button outlineWidth must be normal or bold.');
    }

    if (! in_array($size, $sizes, true)) {
        throw new \InvalidArgumentException('Unsupported button size: ' . $size);
    }
@endphp

<button
    {{ $attributes->class([
        'rai-btn',
        'rai-btn--' . $variant,
        'rai-btn--' . $appearance,
        'rai-btn--' . $size,
        'rai-btn--rounded' => $rounded,
        'rai-btn--pill' => $pill,
        'rai-btn--square' => $square,
        'rai-btn--outline-bold' => $outlineWidth === 'bold',
        'rai-btn--block' => $block,
        ...$spacingClasses,
        'is-loading' => $loading,
    ])->merge([
        'type' => $type,
        'aria-busy' => $loading ? 'true' : 'false',
    ]) }}
    @disabled($disabled || $loading)
>
    @if ($loading)
        <span class="rai-btn__spinner" aria-hidden="true"></span>
    @endif

    @isset($leading)
        <span class="rai-btn__leading" aria-hidden="true">{{ $leading }}</span>
    @endisset

    <span class="rai-btn__label">{{ $slot }}</span>

    @isset($trailing)
        <span class="rai-btn__trailing" aria-hidden="true">{{ $trailing }}</span>
    @endisset
</button>
