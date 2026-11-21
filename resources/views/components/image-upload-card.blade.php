@props([
    'name',
    'label' => null,
    'id' => null,
    'accept' => 'image/*',
    'image' => null,
    'uploadText' => 'Upload Image',
    'clearText' => 'Clear',
    'required' => false,
])

@php
    $inputId = $id ?: 'rai-image-upload-' . \Illuminate\Support\Str::uuid();
    $hasImage = filled($image);
@endphp

<div {{ $attributes->class(['rai-image-upload']) }} data-rai-image-upload>
    @if ($label)
        <label class="rai-image-upload__label" for="{{ $inputId }}">{{ $label }}</label>
    @endif

    <div class="rai-image-upload__preview" data-rai-image-preview>
        <img
            class="rai-image-upload__image"
            @if ($hasImage) src="{{ $image }}" @endif
            alt="{{ $label ? $label . ' preview' : 'Uploaded image preview' }}"
            data-rai-image-element
            @unless ($hasImage) hidden @endunless
        >

        <div class="rai-image-upload__placeholder" data-rai-image-placeholder @if ($hasImage) hidden @endif>
            <svg viewBox="0 0 48 48" aria-hidden="true" fill="none">
                <rect x="5.5" y="7.5" width="37" height="33" rx="5" stroke="currentColor" stroke-width="1.8"/>
                <circle cx="17" cy="18" r="3.5" stroke="currentColor" stroke-width="1.8"/>
                <path d="m8 34 10-10 7 7 5-5 10 10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M24 3v8m-4-4 4-4 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Image preview</span>
        </div>
    </div>

    <input
        class="rai-image-upload__input"
        id="{{ $inputId }}"
        type="file"
        name="{{ $name }}"
        accept="{{ $accept }}"
        data-rai-image-input
        @required($required)
    >

    <div class="rai-image-upload__actions">
        <button type="button" class="rai-image-upload__button rai-image-upload__button--clear" data-rai-image-clear>
            {{ $clearText }}
        </button>
        <button type="button" class="rai-image-upload__button rai-image-upload__button--upload" data-rai-image-trigger>
            <svg viewBox="0 0 20 20" aria-hidden="true" fill="none">
                <path d="M10 13V3m0 0L6.5 6.5M10 3l3.5 3.5M3.5 12.5v3A1.5 1.5 0 0 0 5 17h10a1.5 1.5 0 0 0 1.5-1.5v-3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ $uploadText }}
        </button>
    </div>

    <span class="rai-image-upload__status" data-rai-image-status aria-live="polite"></span>
</div>
