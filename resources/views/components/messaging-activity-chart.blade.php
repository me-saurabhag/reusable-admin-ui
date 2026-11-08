@props([
    'activity' => [],
    'title' => 'Messaging Activity',
    'subtitle' => 'Incoming and outgoing messages',
    'ariaLabel' => null,
])

@php
    $labels = collect($activity['labels'] ?? [])->values()->all();
    $incoming = collect($activity['incoming'] ?? [])->values()->all();
    $outgoing = collect($activity['outgoing'] ?? [])->values()->all();

    $numericValues = array_map(
        static fn ($value) => max(0, (float) $value),
        array_merge($incoming, $outgoing)
    );

    $chartDataMax = max([1, ...$numericValues]);
    $chartStepInterval = $chartDataMax >= 4000 ? 1000 : 100;
    $chartStep = max(
        $chartStepInterval,
        (int) (ceil(($chartDataMax / 4) / $chartStepInterval) * $chartStepInterval)
    );
    $chartMax = $chartStep * 4;

    $chartX = static fn (int $index, int $count): float => $count <= 1
        ? 0
        : ($index * 700 / ($count - 1));

    $chartY = static fn ($value): float => 190
        - (min(max(0, (float) $value), $chartMax) / $chartMax) * 180;

    $makePoints = static function (array $values) use ($chartX, $chartY): string {
        $points = [];
        $count = count($values);

        foreach ($values as $index => $value) {
            $points[] = $chartX($index, $count) . ',' . $chartY($value);
        }

        return implode(' ', $points);
    };

    $incomingPoints = $makePoints($incoming);
    $outgoingPoints = $makePoints($outgoing);
    $chartYAxisLabels = [$chartMax, $chartStep * 3, $chartStep * 2, $chartStep, 0];

    $formatNumber = static fn ($value): string => number_format((float) $value);
    $incomingTotal = $activity['incoming_total'] ?? array_sum($incoming);
    $outgoingTotal = $activity['outgoing_total'] ?? array_sum($outgoing);
    $periodLabel = $activity['period_label'] ?? 'Last 7 days';
    $chartDescription = $ariaLabel ?? 'Line chart comparing incoming and outgoing messages over time';
@endphp

<article {{ $attributes->class(['rai-dashboard-card', 'rai-messaging-chart']) }}>
    <header class="rai-dashboard-card__header">
        <div>
            <h2 class="rai-dashboard-card__title">{{ $title }}</h2>
            @if (filled($subtitle))
                <p class="rai-dashboard-card__subtitle">{{ $subtitle }}</p>
            @endif
        </div>
        <span class="rai-dashboard-card__period">{{ $periodLabel }}</span>
    </header>

    <div class="rai-messaging-chart__legend" aria-label="Chart legend">
        <span><i class="rai-messaging-chart__legend-dot rai-messaging-chart__legend-dot--incoming"></i> Incoming</span>
        <span><i class="rai-messaging-chart__legend-dot rai-messaging-chart__legend-dot--outgoing"></i> Outgoing</span>
    </div>

    <div class="rai-messaging-chart__plot-wrap" role="img" aria-label="{{ $chartDescription }}">
        <div class="rai-messaging-chart__y-labels" aria-hidden="true">
            @foreach ($chartYAxisLabels as $yLabel)
                <span>{{ $formatNumber($yLabel) }}</span>
            @endforeach
        </div>

        <div class="rai-messaging-chart__plot">
            @for ($line = 0; $line < 5; $line++)
                <div class="rai-messaging-chart__gridline"></div>
            @endfor

            <svg viewBox="0 0 700 220" preserveAspectRatio="none" aria-hidden="true" focusable="false">
                @if (filled($incomingPoints))
                    <polyline class="rai-messaging-chart__line rai-messaging-chart__line--incoming" points="{{ $incomingPoints }}"/>
                @endif
                @if (filled($outgoingPoints))
                    <polyline class="rai-messaging-chart__line rai-messaging-chart__line--outgoing" points="{{ $outgoingPoints }}"/>
                @endif

                @foreach ($incoming as $index => $value)
                    <circle class="rai-messaging-chart__point rai-messaging-chart__point--incoming"
                            cx="{{ $chartX($index, count($incoming)) }}"
                            cy="{{ $chartY($value) }}" r="4"/>
                @endforeach
                @foreach ($outgoing as $index => $value)
                    <circle class="rai-messaging-chart__point rai-messaging-chart__point--outgoing"
                            cx="{{ $chartX($index, count($outgoing)) }}"
                            cy="{{ $chartY($value) }}" r="4"/>
                @endforeach
            </svg>
        </div>

        <div class="rai-messaging-chart__x-labels" aria-hidden="true">
            @foreach ($labels as $label)
                <span>{{ $label }}</span>
            @endforeach
        </div>
    </div>

    <footer class="rai-messaging-chart__footer">
        <div>
            <span class="rai-messaging-chart__total-label">Incoming this period</span>
            <strong>{{ $formatNumber($incomingTotal) }}</strong>
        </div>
        <div>
            <span class="rai-messaging-chart__total-label">Outgoing this period</span>
            <strong>{{ $formatNumber($outgoingTotal) }}</strong>
        </div>
    </footer>
</article>
