@props(['span' => 12, 'sm' => null, 'md' => null, 'lg' => null])
@php
    foreach (['span' => $span, 'sm' => $sm, 'md' => $md, 'lg' => $lg] as $breakpoint => $value) {
        if ($value !== null && (! is_numeric($value) || (int) $value < 1 || (int) $value > 12)) {
            throw new \InvalidArgumentException("Column {$breakpoint} span must be between 1 and 12.");
        }
    }
    $classes = ['rai-col', 'rai-col--' . (int) $span];
    foreach (['sm' => $sm, 'md' => $md, 'lg' => $lg] as $breakpoint => $value) {
        if ($value !== null) $classes[] = "rai-col--{$breakpoint}-" . (int) $value;
    }
@endphp
<div {{ $attributes->class($classes) }}>{{ $slot }}</div>
