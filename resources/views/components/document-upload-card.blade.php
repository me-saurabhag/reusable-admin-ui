@props([
    'name',
    'label' => null,
    'id' => null,
    'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv',
    'uploadText' => 'Upload Document',
    'clearText' => 'Clear',
    'placeholderText' => 'No document selected',
    'required' => false,
])

@php
    $inputId = $id ?: 'rai-document-upload-' . \Illuminate\Support\Str::uuid();
@endphp

<div {{ $attributes->class(['rai-document-upload']) }} data-rai-document-upload>
    @if ($label)
        <label class="rai-document-upload__label" for="{{ $inputId }}">{{ $label }}</label>
    @endif

    <div class="rai-document-upload__preview" data-rai-document-preview>
        <div class="rai-document-upload__placeholder" data-rai-document-placeholder>
            <svg viewBox="0 0 64 72" aria-hidden="true" fill="none">
                <path d="M12 3.5h25l15 15V64a4.5 4.5 0 0 1-4.5 4.5h-35A4.5 4.5 0 0 1 8 64V8a4.5 4.5 0 0 1 4-4.5Z" fill="currentColor" opacity=".1"/>
                <path d="M37 4v13a2 2 0 0 0 2 2h13M13 4h24l15 15v44a5 5 0 0 1-5 5H13a5 5 0 0 1-5-5V9a5 5 0 0 1 5-5Z" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                <path d="M18 34h28M18 43h28M18 52h19" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
            </svg>
            <span>{{ $placeholderText }}</span>
        </div>
        <div class="rai-document-upload__file" data-rai-document-file hidden>
            <span class="rai-document-upload__file-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M6 2.75h8l5 5V21H6a2 2 0 0 1-2-2V4.75a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                    <path d="M14 3v5h5M8 13h8M8 16.5h8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
            </span>
            <span class="rai-document-upload__file-name" data-rai-document-file-name></span>
        </div>
    </div>

    <input
        class="rai-document-upload__input"
        id="{{ $inputId }}"
        type="file"
        name="{{ $name }}"
        accept="{{ $accept }}"
        data-rai-document-input
        @required($required)
    >

    <div class="rai-document-upload__actions">
        <button type="button" class="rai-document-upload__button rai-document-upload__button--clear" data-rai-document-clear>
            {{ $clearText }}
        </button>
        <button type="button" class="rai-document-upload__button rai-document-upload__button--upload" data-rai-document-trigger>
            <svg viewBox="0 0 20 20" aria-hidden="true" fill="none">
                <path d="M10 13V3m0 0L6.5 6.5M10 3l3.5 3.5M3.5 12.5v3A1.5 1.5 0 0 0 5 17h10a1.5 1.5 0 0 0 1.5-1.5v-3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ $uploadText }}
        </button>
    </div>

    <span class="rai-document-upload__status" data-rai-document-status aria-live="polite"></span>
</div>
