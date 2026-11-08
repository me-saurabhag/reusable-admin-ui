@props([
    'level' => 2,
    'size' => null,
    'weight' => 'semibold',
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

    if (! in_array((int) $level, [1, 2, 3, 4, 5, 6], true)) {
        throw new \InvalidArgumentException('Heading level must be between 1 and 6.');
    }

    if ($size !== null && ! in_array($size, ['display', 'h1', 'h2', 'h3', 'h4', 'h5'], true)) {
        throw new \InvalidArgumentException('Unsupported heading size.');
    }

    if (! in_array($weight, ['regular', 'medium', 'semibold', 'bold'], true)) {
        throw new \InvalidArgumentException('Unsupported heading weight.');
    }

    $tag = 'h' . (int) $level;
    $visualSize = $size ?: 'h' . (int) $level;
@endphp

<{{ $tag }} {{ $attributes->class(['rai-heading', 'rai-heading--' . $visualSize, 'rai-heading--' . $weight, ...$spacingClasses]) }}>
    {{ $slot }}
</{{ $tag }}>
