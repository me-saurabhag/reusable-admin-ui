@props([
    'title',
    'open' => false,
    'disabled' => false,
])

@php($itemId = $attributes->get('id') ?: 'rai-accordion-' . \Illuminate\Support\Str::uuid())
<section {{ $attributes->except('id')->class(['rai-accordion__item', 'is-open' => $open, 'is-disabled' => $disabled]) }} data-rai-accordion-item>
    <h3 class="rai-accordion__heading">
        <button type="button" class="rai-accordion__trigger" id="{{ $itemId }}-trigger" aria-expanded="{{ $open ? 'true' : 'false' }}" aria-controls="{{ $itemId }}-panel" data-rai-accordion-trigger @disabled($disabled)>
            @if (isset($icon))<span class="rai-accordion__icon" aria-hidden="true">{{ $icon }}</span>@endif
            <span class="rai-accordion__title">{{ $title }}</span>
            <span class="rai-accordion__chevron" aria-hidden="true"></span>
        </button>
    </h3>
    <div class="rai-accordion__panel" id="{{ $itemId }}-panel" role="region" aria-labelledby="{{ $itemId }}-trigger" data-rai-accordion-panel @if (! $open) hidden @endif>
        <div class="rai-accordion__content">{{ $slot }}</div>
    </div>
</section>
