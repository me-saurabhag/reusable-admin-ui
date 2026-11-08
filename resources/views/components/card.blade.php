@props(['title' => null, 'description' => null])
<section {{ $attributes->class(['rai-card']) }}>
    @if ($title || isset($header))
        <div class="rai-card__header">
            <div>@if ($title)<h2 class="rai-card__title">{{ $title }}</h2>@endif @if ($description)<p class="rai-card__description">{{ $description }}</p>@endif</div>
            @isset($actions)<div>{{ $actions }}</div>@endisset
        </div>
    @endif
    <div class="rai-card__body">{{ $slot }}</div>
    @isset($footer)<div class="rai-card__footer">{{ $footer }}</div>@endisset
</section>
