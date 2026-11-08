<div {{ $attributes->class('rai-table-toolbar') }}>
    <div class="rai-table-toolbar__copy">
        @isset($heading)<div class="rai-table-toolbar__title">{{ $heading }}</div>@endisset
        @isset($description)<div class="rai-table-toolbar__description">{{ $description }}</div>@endisset
    </div>
    @isset($actions)<div class="rai-table-toolbar__actions">{{ $actions }}</div>@endisset
    {{ $slot }}
</div>
