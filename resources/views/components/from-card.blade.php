@props([
    'title' => null,
    'subtitle' => null,
])

<section {{ $attributes->class(['rai-form-card']) }}>
    @if ($title || $subtitle)
        <header class="rai-form-card__header">
            @if ($title)
                <h2 class="rai-form-card__title">{{ $title }}</h2>
            @endif

            @if ($subtitle)
                <p class="rai-form-card__subtitle">{{ $subtitle }}</p>
            @endif
        </header>
        <div class="rai-form-card__divider" aria-hidden="true"></div>
    @endif

    <div class="rai-form-card__body">
        {{ $slot }}
    </div>
</section>
