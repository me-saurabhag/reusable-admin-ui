@props([
    'size' => 'body',
    'weight' => 'regular',
    'color' => 'default',
    'as' => 'p',
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

    if (! in_array($size, ['body', 'small', 'caption', 'tiny'], true)) {
        throw new \InvalidArgumentException('Unsupported text size.');
    }

    if (! in_array($weight, ['regular', 'medium', 'semibold', 'bold'], true)) {
        throw new \InvalidArgumentException('Unsupported text weight.');
    }

    if (! in_array($color, ['default', 'muted', 'secondary', 'primary', 'success', 'warning', 'danger'], true)) {
        throw new \InvalidArgumentException('Unsupported text color.');
    }

    if (! in_array($as, ['p', 'span', 'div', 'strong', 'small'], true)) {
        throw new \InvalidArgumentException('Unsupported text element.');
    }
@endphp

<{{ $as }} {{ $attributes->class([
    'rai-text',
    'rai-text--' . $size,
    'rai-text--' . $weight,
    'rai-text--' . $color,
    ...$spacingClasses,
]) }}>
    {{ $slot }}
</{{ $as }}>
