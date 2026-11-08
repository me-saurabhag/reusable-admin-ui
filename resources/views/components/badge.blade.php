@props([
    'variant' => 'neutral',
    'size' => 'md',
    'appearance' => 'soft',
    'pill' => false,
    'dot' => false,
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

    if (! in_array($variant, ['primary', 'success', 'warning', 'danger', 'info', 'neutral'], true)) {
        throw new \InvalidArgumentException('Unsupported badge variant: ' . $variant);
    }

    if (! in_array($appearance, ['soft', 'solid', 'outline'], true)) {
        throw new \InvalidArgumentException('Badge appearance must be soft, solid, or outline.');
    }

    if (! in_array($size, ['sm', 'md'], true)) {
        throw new \InvalidArgumentException('Badge size must be sm or md.');
    }
@endphp

<span {{ $attributes->class([
    'rai-badge',
    'rai-badge--' . $variant,
    'rai-badge--' . $size,
    'rai-badge--' . $appearance,
    'rai-badge--dot' => $dot,
    ...$spacingClasses,
    'rai-badge--pill' => $pill,
]) }}>
    {{ $slot }}
</span>
