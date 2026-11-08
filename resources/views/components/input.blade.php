@props([
    'name',
    'label' => null,
    'id' => null,
    'type' => 'text',
    'value' => null,
    'size' => 'md',
    'appearance' => 'outline',
    'required' => false,
    'help' => null,
    'error' => null,
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

    if (! in_array($appearance, ['outline', 'filled', 'underline'], true)) {
        throw new \InvalidArgumentException('Field appearance must be outline, filled, or underline.');
    }

    if (! in_array($size, ['sm', 'md', 'lg'], true)) {
        throw new \InvalidArgumentException('Input size must be sm, md, or lg.');
    }

    $inputId = $id ?: 'rai-input-' . \Illuminate\Support\Str::uuid();
    $validationError = $error ?? (isset($errors) ? ($errors->first($name) ?: null) : null);
    $descriptionId = $inputId . '-description';
    $hasDescription = filled($help) || filled($validationError);
@endphp

<div {{ $attributes->only([])->class(array_merge(['rai-field'], $spacingClasses)) }}>
    @if ($label)
        <label class="rai-field__label" for="{{ $inputId }}">
            {{ $label }}
            @if ($required)
                <span class="rai-field__required" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <input
        {{ $attributes->class([
            'rai-control',
            'rai-control--' . $size,
            'rai-control--' . $appearance,
            'is-invalid' => filled($validationError),
        ])->merge([
            'id' => $inputId,
            'name' => $name,
            'type' => $type,
            'value' => old($name, $value),
            'aria-describedby' => $hasDescription ? $descriptionId : null,
            'aria-invalid' => filled($validationError) ? 'true' : 'false',
        ]) }}
        @required($required)
    >

    @if ($hasDescription)
        <div id="{{ $descriptionId }}" class="rai-field__description">
            @if ($help)
                <span class="rai-field__help">{{ $help }}</span>
            @endif
            @if ($validationError)
                <span class="rai-field__error" role="alert">{{ $validationError }}</span>
            @endif
        </div>
    @endif
</div>
