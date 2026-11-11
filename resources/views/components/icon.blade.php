@props([
    'name',
    'size' => 24,
    'title' => null,
])

@php
    $iconName = is_string($name) ? $name : '';
    if (! preg_match('/^[a-z0-9-]+$/D', $iconName)) {
        throw new \InvalidArgumentException('The admin-ui icon name must contain only lowercase letters, numbers and hyphens.');
    }

    $iconSize = is_numeric($size) ? max(1, (int) $size) . 'px' : (string) $size;
    $spriteUrl = asset(config('admin-ui.assets.icon_sprite', 'vendor/admin-ui/icons.svg'));
@endphp

<svg
    {{ $attributes->class(['rai-icon'])->merge(['style' => 'width: ' . $iconSize . '; height: ' . $iconSize . ';']) }}
    width="{{ is_numeric($size) ? max(1, (int) $size) : 24 }}"
    height="{{ is_numeric($size) ? max(1, (int) $size) : 24 }}"
    viewBox="0 0 24 24"
    fill="none"
    @if (filled($title))
        role="img"
        aria-label="{{ $title }}"
    @else
        aria-hidden="true"
        focusable="false"
    @endif
>
    <use href="{{ $spriteUrl }}#{{ $iconName }}"></use>
</svg>
