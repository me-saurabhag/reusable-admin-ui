@props([
    'mode' => 'multiple',
    'appearance' => 'default',
])

@php
    if (! in_array($mode, ['single', 'multiple'], true)) {
        throw new \InvalidArgumentException('Accordion mode must be single or multiple.');
    }
    if (! in_array($appearance, ['default', 'bordered', 'separated', 'flush'], true)) {
        throw new \InvalidArgumentException('Unsupported accordion appearance.');
    }
@endphp

<div {{ $attributes->class(['rai-accordion', 'rai-accordion--' . $appearance]) }} data-rai-accordion data-rai-accordion-mode="{{ $mode }}">
    {{ $slot }}
</div>
