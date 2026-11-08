@props([
    'name' => 'transaction_pin',
    'label' => 'Transaction PIN',
    'description' => null,
    'length' => 6,
    'masked' => true,
    'required' => false,
])

@php
    $length = max(4, min(8, (int) $length));
    $pinId = $attributes->get('id') ?: 'rai-pin-' . \Illuminate\Support\Str::uuid();
    $descriptionId = $description ? $pinId . '-description' : null;
@endphp

<div
    {{ $attributes->except(['id'])->class(['rai-pin-input']) }}
    data-rai-pin-input
    data-pin-length="{{ $length }}"
    data-pin-required="{{ $required ? 'true' : 'false' }}"
    data-pin-masked="{{ $masked ? 'true' : 'false' }}"
>
    @if($label)
        <label class="rai-pin-input__label" for="{{ $pinId }}-1">{{ $label }}</label>
    @endif

    @if($description)
        <p class="rai-pin-input__description" id="{{ $descriptionId }}">{{ $description }}</p>
    @endif

    <div
        class="rai-pin-input__fields"
        role="group"
        aria-label="{{ $label ?: 'PIN input' }}"
        @if($descriptionId) aria-describedby="{{ $descriptionId }}" @endif
    >
        @for($index = 1; $index <= $length; $index++)
            <input
                type="{{ $masked ? 'password' : 'text' }}"
                class="pin-box rai-pin-input__box"
                id="{{ $pinId }}-{{ $index }}"
                data-pin-digit
                inputmode="numeric"
                pattern="[0-9]*"
                maxlength="1"
                autocomplete="off"
                autocapitalize="off"
                spellcheck="false"
                aria-label="PIN digit {{ $index }} of {{ $length }}"
                aria-required="{{ $required ? 'true' : 'false' }}"
            >
        @endfor
    </div>

    <input
        type="hidden"
        name="{{ $name }}"
        value=""
        data-pin-value
    >
</div>
