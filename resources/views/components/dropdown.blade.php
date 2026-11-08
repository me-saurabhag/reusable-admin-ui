@props([
    'placement' => 'bottom-start',
    'width' => 'md',
])

@php
    if (! in_array($placement, ['bottom-start', 'bottom-end', 'top-start', 'top-end'], true)) {
        throw new \InvalidArgumentException('Unsupported dropdown placement: ' . $placement);
    }
    if (! in_array($width, ['sm', 'md', 'lg', 'auto'], true)) {
        throw new \InvalidArgumentException('Dropdown width must be sm, md, lg, or auto.');
    }
    $dropdownId = $attributes->get('id') ?: 'rai-dropdown-' . \Illuminate\Support\Str::uuid();
@endphp

<div {{ $attributes->except('id')->class(['rai-dropdown', 'rai-dropdown--' . $placement, 'rai-dropdown--' . $width]) }} data-rai-dropdown>
    <div class="rai-dropdown__trigger" data-rai-dropdown-trigger>
        {{ $trigger }}
    </div>
    <div class="rai-dropdown__menu" id="{{ $dropdownId }}-menu" role="menu" hidden data-rai-dropdown-menu>
        {{ $slot }}
    </div>
</div>
