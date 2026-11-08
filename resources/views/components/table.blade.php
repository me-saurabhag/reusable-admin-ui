@props([
    'appearance' => 'default',
    'size' => 'md',
    'hoverable' => true,
    'striped' => false,
    'responsive' => true,
    'flush' => false,
])
@php
    $appearances = ['default', 'bordered', 'minimal'];
    $sizes = ['sm', 'md', 'lg'];
    if (! in_array($appearance, $appearances, true)) throw new \InvalidArgumentException('Unsupported table appearance: ' . $appearance);
    if (! in_array($size, $sizes, true)) throw new \InvalidArgumentException('Unsupported table size: ' . $size);
    $classes = ['rai-table-card', 'rai-table-card--' . $appearance, 'rai-table-card--' . $size];
    if ($flush) $classes[] = 'rai-table-card--flush';
@endphp
<section {{ $attributes->class($classes) }}>
    @if(isset($heading) || isset($description) || isset($actions))
        <div class="rai-table-toolbar">
            <div class="rai-table-toolbar__copy">
                @isset($heading)<div class="rai-table-toolbar__title">{{ $heading }}</div>@endisset
                @isset($description)<div class="rai-table-toolbar__description">{{ $description }}</div>@endisset
            </div>
            @isset($actions)<div class="rai-table-toolbar__actions">{{ $actions }}</div>@endisset
        </div>
    @endif
    <div @class(['rai-table-responsive' => $responsive])>
        <table class="rai-table rai-table--{{ $size }} {{ $hoverable ? 'rai-table--hoverable' : '' }} {{ $striped ? 'rai-table--striped' : '' }}">
            @isset($caption)<caption class="rai-table__caption">{{ $caption }}</caption>@endisset
            @isset($header)<thead>{{ $header }}</thead>@endisset
            <tbody>{{ $slot }}</tbody>
        </table>
    </div>
    @isset($footer)<div class="rai-table-footer">{{ $footer }}</div>@endisset
</section>
