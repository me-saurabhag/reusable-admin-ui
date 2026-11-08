@props([
    'id',
    'title' => 'Details',
    'subtitle' => null,
    'width' => '560px',
    'formId' => null,
    'submitLabel' => 'Save changes',
    'cancelLabel' => 'Cancel',
    'showFooter' => true,
    'submitDisabled' => false,
])

@php
    $formId = $formId ?: $id . '-form';
    $validWidth = preg_match('/^(\d{2,4}px|\d{2,3}vw|\d{2,3}%)$/', (string) $width) === 1;
    if (! $validWidth) {
        throw new \InvalidArgumentException('Offcanvas width must be a valid px, vw, or % value (for example 560px or 45vw).');
    }
@endphp

<div
    {{ $attributes->class(['offcanvas', 'offcanvas-end', 'rai-offcanvas'])->merge([
        'id' => $id,
        'tabindex' => '-1',
        'aria-labelledby' => $id . '-title',
        'data-rai-offcanvas' => '',
        'style' => '--rai-offcanvas-width: ' . $width,
    ]) }}
>
    <form id="{{ $formId }}" class="rai-offcanvas__form" data-rai-offcanvas-form>
        <div class="rai-offcanvas__header">
            <div class="rai-offcanvas__heading">
                <h2 class="rai-offcanvas__title" id="{{ $id }}-title">{{ $title }}</h2>
                @if ($subtitle)
                    <p class="rai-offcanvas__subtitle">{{ $subtitle }}</p>
                @endif
            </div>
            @isset($headerActions)
                <div class="rai-offcanvas__header-actions">{{ $headerActions }}</div>
            @endisset
            <button type="button" class="rai-offcanvas__close" data-bs-dismiss="offcanvas" aria-label="Close">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m18 6-12 12M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="rai-offcanvas__body">
            {{ $slot }}
        </div>

        @if ($showFooter)
            <div class="rai-offcanvas__footer">
                <button type="button" class="rai-offcanvas__cancel" data-bs-dismiss="offcanvas" data-rai-offcanvas-cancel>
                    {{ $cancelLabel }}
                </button>
                <button type="submit" class="rai-offcanvas__submit" data-rai-offcanvas-submit @disabled($submitDisabled)>
                    <span class="rai-offcanvas__submit-label">{{ $submitLabel }}</span>
                    <span class="rai-offcanvas__spinner" aria-hidden="true"></span>
                </button>
            </div>
        @endif
    </form>
</div>
