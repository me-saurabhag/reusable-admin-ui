@props([
    'name',
    'label' => null,
    'subtitle' => null,
    'id' => null,
    'accept' => 'image/jpeg,image/png',
    'image' => null,
    'placeholderImage' => null,
    'placeholderAlt' => 'Document image placeholder',
    'formatsText' => 'JPG, PNG',
    'maxSize' => 'Max 5 MB',
    'uploadText' => 'Upload',
    'required' => false,
])

@php
    $inputId = $id ?: 'rai-image-upload-' . \Illuminate\Support\Str::uuid();
    $hasImage = filled($image);
    $hasPlaceholderImage = filled($placeholderImage);
@endphp

<div {{ $attributes->class(['rai-image-upload']) }} data-rai-image-upload>
    <div class="rai-image-upload__header">
        <div class="rai-image-upload__heading">
            @if ($label)
                <label class="rai-image-upload__label" for="{{ $inputId }}">{{ $label }}</label>
            @endif
            @if ($subtitle)
                <p class="rai-image-upload__subtitle">{{ $subtitle }}</p>
            @endif
        </div>
        @if ($required)
            <span class="rai-image-upload__required">Required</span>
        @endif
    </div>

    <div class="rai-image-upload__preview" data-rai-image-preview>
        <div class="rai-image-upload__preview-inner">
            <img class="rai-image-upload__image"
                @if ($hasImage) src="{{ $image }}" @endif
                alt="{{ $label ? $label . ' preview' : 'Uploaded image preview' }}"
                data-rai-image-element
                @unless ($hasImage) hidden @endunless
            >
            @if ($hasPlaceholderImage)
                <img class="rai-image-upload__placeholder-image"
                    src="{{ $placeholderImage }}"
                    alt="{{ $placeholderAlt }}"
                    data-rai-image-placeholder-image
                    @if ($hasImage) hidden @endif
                >
            @else
                <div class="rai-image-upload__placeholder" data-rai-image-placeholder @if ($hasImage) hidden @endif>
                    <svg viewBox="0 0 320 180" aria-hidden="true">
                        <rect width="320" height="180" rx="14" fill="#f4f4f4"/>
                        <circle cx="72" cy="64" r="25" fill="#dedede"/>
                        <path d="M28 132c0-21 17-38 38-38h12c21 0 38 17 38 38v4H28z" fill="#dedede"/>
                        <rect x="160" y="54" width="112" height="22" rx="11" fill="#dedede"/>
                        <rect x="160" y="94" width="68" height="22" rx="11" fill="#dedede"/>
                    </svg>
                </div>
            @endif
        </div>
    </div>

    <input class="rai-image-upload__input" id="{{ $inputId }}" type="file"
        name="{{ $name }}" accept="{{ $accept }}" data-rai-image-input @required($required)>

    <div class="rai-image-upload__footer">
        <div class="rai-image-upload__meta">
            <span>{{ $formatsText }}</span>
            @if ($maxSize)
                <span class="rai-image-upload__meta-separator" aria-hidden="true">·</span>
                <span>{{ $maxSize }}</span>
            @endif
        </div>
        <button type="button" class="rai-image-upload__button" data-rai-image-trigger>{{ $uploadText }}</button>
        <span class="rai-image-upload__status" data-rai-image-status aria-live="polite"></span>
    </div>
</div>
