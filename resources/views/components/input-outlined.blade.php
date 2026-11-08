@props([
    'name',
    'label' => null,
    'id' => null,
    'type' => 'text',
    'value' => null,
    'required' => false,
    'help' => null,
    'error' => null,
])

@php
    $inputId = $id ?: 'rai-input-' . \Illuminate\Support\Str::uuid();
    $validationError = $error;

    if ($validationError === null && isset($errors)) {
        $validationError = $errors->first($name) ?: null;
    }

    $descriptionId = $inputId . '-description';
    $hasDescription = filled($help) || filled($validationError);
@endphp

<div class="rai-form-field">
    @if ($label)
        <label class="form-label rai-form-label" for="{{ $inputId }}">
            {{ $label }}
            @if ($required)
                <span class="rai-form-required" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <input
        {{ $attributes->class([
            'form-control',
            'rai-input',
            'rai-input-outlined',
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
        <div id="{{ $descriptionId }}" class="rai-form-description">
            @if ($help)
                <span class="form-text rai-form-help">{{ $help }}</span>
            @endif

            @if ($validationError)
                <span class="invalid-feedback d-block rai-form-error" role="alert">{{ $validationError }}</span>
            @endif
        </div>
    @endif
</div>
