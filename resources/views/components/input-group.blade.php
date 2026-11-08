@props([
    'size' => 'md',
    'fullWidth' => true,
])

@php
    if (! in_array($size, ['sm', 'md', 'lg'], true)) {
        throw new \InvalidArgumentException('Input group size must be sm, md, or lg.');
    }
@endphp

<div {{ $attributes->class([
    'rai-input-group',
    'rai-input-group--' . $size,
    'rai-input-group--full' => $fullWidth,
    'rai-input-group--has-prepend' => isset($prepend),
    'rai-input-group--has-append' => isset($append),
]) }}>
    @isset($prepend)
        <span class="rai-input-group__addon rai-input-group__addon--prepend">{{ $prepend }}</span>
    @endisset

    <div class="rai-input-group__control">{{ $slot }}</div>

    @isset($append)
        <span class="rai-input-group__addon rai-input-group__addon--append">{{ $append }}</span>
    @endisset
</div>
