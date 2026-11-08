@props([
    'type' => 'unordered',
    'appearance' => 'default',
    'size' => 'md',
    'marker' => 'none',
    'gap' => 'md',
])
@php
    $tag = $type === 'ordered' ? 'ol' : 'ul';
    if (! in_array($type, ['ordered', 'unordered'], true)) throw new \InvalidArgumentException('List type must be ordered or unordered.');
    if (! in_array($appearance, ['default', 'bordered', 'divided', 'flush'], true)) throw new \InvalidArgumentException('Unsupported list appearance.');
    if (! in_array($size, ['sm', 'md', 'lg'], true)) throw new \InvalidArgumentException('List size must be sm, md or lg.');
    if (! in_array($marker, ['none', 'bullet', 'number', 'icon'], true)) throw new \InvalidArgumentException('Unsupported list marker.');
    if (! in_array($gap, ['none', 'sm', 'md', 'lg'], true)) throw new \InvalidArgumentException('Unsupported list gap.');
@endphp
<{{ $tag }} {{ $attributes->class(['rai-list', 'rai-list--' . $appearance, 'rai-list--' . $size, 'rai-list--marker-' . $marker, 'rai-list--gap-' . $gap]) }}>
    {{ $slot }}
</{{ $tag }}>
