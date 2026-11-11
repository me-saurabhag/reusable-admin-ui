@props([])

<div {{ $attributes->class(['rai-dashboard-overview']) }}>
    <div class="rai-dashboard-overview__item">
        {{ $activity }}
    </div>

    <div class="rai-dashboard-overview__item">
        {{ $health }}
    </div>
</div>
