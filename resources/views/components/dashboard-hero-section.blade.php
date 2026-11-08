@props([
    'title',
    'subtitle' => null,
    'refreshedAt' => null,
    'date' => null,
    'stats' => [],
    'ariaLabel' => 'Dashboard overview',
])

@php
    $heroPatternId = 'rai-dashboard-hero-grid-' . \Illuminate\Support\Str::uuid();
@endphp

<section {{ $attributes->class(['rai-dashboard-hero']) }} aria-label="{{ $ariaLabel }}">
    <span class="rai-dashboard-hero__accent rai-dashboard-hero__accent--top" aria-hidden="true"></span>
    <span class="rai-dashboard-hero__accent rai-dashboard-hero__accent--bottom" aria-hidden="true"></span>

    <svg class="rai-dashboard-hero__grid" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <defs>
            <pattern id="{{ $heroPatternId }}" width="28" height="28" patternUnits="userSpaceOnUse">
                <path d="M28 0H0V28" fill="none" stroke="white" stroke-width="1"></path>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#{{ $heroPatternId }})"></rect>
    </svg>

    <div class="rai-dashboard-hero__top">
        <div class="rai-dashboard-hero__badges">
            @if (filled($refreshedAt))
                <span class="rai-dashboard-hero__chip">
                    <x-admin-ui::icon name="refresh" size="14" />
                    {{ $refreshedAt }}
                </span>
            @endif
        </div>

        <div class="rai-dashboard-hero__actions-wrap">
            @isset($actions)
                <div class="rai-dashboard-hero__actions">{{ $actions }}</div>
            @endisset
            @if (filled($date))
                <span class="rai-dashboard-hero__date">{{ $date }}</span>
            @endif
        </div>
    </div>

    <div class="rai-dashboard-hero__heading">
        <h1 class="rai-dashboard-hero__title">{{ $title }}</h1>
        @if (filled($subtitle))
            <p class="rai-dashboard-hero__subtitle">{{ $subtitle }}</p>
        @endif
    </div>

    @if (count($stats))
        <div class="rai-dashboard-hero__stats">
            @foreach ($stats as $stat)
                <div class="rai-dashboard-hero__stat">
                    <span class="rai-dashboard-hero__stat-label">{{ $stat['label'] ?? '' }}</span>
                    <span class="rai-dashboard-hero__stat-value">
                        @if ($stat['indicator'] ?? false)
                            <span class="rai-dashboard-hero__indicator" aria-hidden="true"></span>
                        @endif
                        {{ $stat['value'] ?? '—' }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</section>
