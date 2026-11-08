@props([
    'gap' => '3',
    'align' => 'stretch',
    'as' => 'div',
])

@php
    $allowedGaps = ['0', '1', '2', '3', '4', '5', '6', '8', '10', '12', '16'];
    if (! in_array((string) $gap, $allowedGaps, true)) {
        throw new \InvalidArgumentException('Stack gap must be one of: ' . implode(', ', $allowedGaps) . '.');
    }
    if (! in_array($align, ['start', 'center', 'end', 'stretch'], true)) {
        throw new \InvalidArgumentException('Stack align must be start, center, end, or stretch.');
    }
    if (! in_array($as, ['div', 'section', 'nav', 'aside'], true)) {
        throw new \InvalidArgumentException('Stack element must be div, section, nav, or aside.');
    }
@endphp

<{{ $as }} {{ $attributes->class(['rai-stack', 'rai-stack--align-' . $align])->merge(['style' => '--rai-stack-gap: var(--rai-space-' . $gap . ')']) }}>
    {{ $slot }}
</{{ $as }}>
