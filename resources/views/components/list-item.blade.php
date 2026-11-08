@props(['title' => null, 'description' => null, 'meta' => null, 'variant' => null])
<li {{ $attributes->class(['rai-list__item', $variant ? 'rai-list__item--' . $variant : null]) }}>
    @isset($leading)<span class="rai-list__leading">{{ $leading }}</span>@endisset
    <div class="rai-list__main">
        @if($title)<div class="rai-list__title">{{ $title }}</div>@endif
        @if($description)<div class="rai-list__description">{{ $description }}</div>@endif
        @if(! $title && ! $description)<div class="rai-list__content">{{ $slot }}</div>
        @elseif(trim((string) $slot) !== '')<div class="rai-list__content">{{ $slot }}</div>@endif
    </div>
    @if($meta)<span class="rai-list__meta">{{ $meta }}</span>@endif
    @isset($trailing)<span class="rai-list__trailing">{{ $trailing }}</span>@endisset
</li>
