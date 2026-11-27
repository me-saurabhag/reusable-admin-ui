@props([
    'name',
    'label' => null,
    'subtitle' => null,
    'id' => null,
    'accept' => 'image/jpeg,image/png',
    'image' => null,
    'formatsText' => 'JPG, PNG',
    'maxSize' => 'Max 5 MB',
    'uploadText' => 'Upload photo',
    'changeText' => 'Change photo',
    'removeText' => 'Remove',
    'required' => false,
])

@php
    $inputId = $id ?: 'rai-profile-photo-' . \Illuminate\Support\Str::uuid();
    $hasImage = filled($image);
@endphp

<div {{ $attributes->class(['rai-profile-photo']) }} data-rai-profile-photo>
    @if ($label || $subtitle || $required)
        <div class="rai-profile-photo__header">
            <div class="rai-profile-photo__heading">
                @if ($label)<label class="rai-profile-photo__label" for="{{ $inputId }}">{{ $label }}</label>@endif
                @if ($subtitle)<p class="rai-profile-photo__subtitle">{{ $subtitle }}</p>@endif
            </div>
            @if ($required)<span class="rai-profile-photo__required">Required</span>@endif
        </div>
    @endif
    <div class="rai-profile-photo__content">
        <div class="rai-profile-photo__avatar">
            <img class="rai-profile-photo__image" @if ($hasImage) src="{{ $image }}" @endif alt="{{ $label ? $label . ' preview' : 'Profile photo preview' }}" data-rai-profile-photo-image @unless ($hasImage) hidden @endunless>
            <div class="rai-profile-photo__placeholder" data-rai-profile-photo-placeholder @if ($hasImage) hidden @endif aria-hidden="true">
                <svg viewBox="0 0 64 64" fill="none"><circle cx="32" cy="22" r="12"/><path d="M10 56c1.8-11.4 10.6-18 22-18s20.2 6.6 22 18"/></svg>
            </div>
        </div>
        <input class="rai-profile-photo__input" id="{{ $inputId }}" type="file" name="{{ $name }}" accept="{{ $accept }}" data-rai-profile-photo-input @required($required)>
        <div class="rai-profile-photo__actions">
            <button type="button" class="rai-profile-photo__button rai-profile-photo__button--primary" data-rai-profile-photo-trigger>{{ $hasImage ? $changeText : $uploadText }}</button>
            <button type="button" class="rai-profile-photo__button rai-profile-photo__button--remove" data-rai-profile-photo-remove @unless ($hasImage) hidden @endunless>{{ $removeText }}</button>
        </div>
        <div class="rai-profile-photo__meta"><span>{{ $formatsText }}</span>@if ($maxSize)<span aria-hidden="true">·</span><span>{{ $maxSize }}</span>@endif</div>
        <span class="rai-profile-photo__status" data-rai-profile-photo-status aria-live="polite"></span>
    </div>
</div>
