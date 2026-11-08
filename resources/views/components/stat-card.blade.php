@props([
    'variant' => 'revenue',
    'title' => null,
    'value' => null,
    'icon' => null,
    'trend' => null,
    'trendLabel' => null,
    'badge' => null,
    'primaryLabel' => null,
    'primaryValue' => null,
    'secondaryLabel' => null,
    'secondaryValue' => null,
    'href' => null,
    'height' => null,
    'trendVariant' => 'success',
    'iconVariant' => 'primary',
])
@php
    $variants = ['split', 'revenue', 'accent-action', 'icon-block', 'compact', 'watermark', 'dashboard'];

    if (! in_array($variant, $variants, true)) {
        throw new \InvalidArgumentException('Unsupported stat-card variant: ' . $variant);
    }

    $tag = filled($href) ? 'a' : 'article';
    $classes = ['rai-stat-card', 'rai-stat-card--' . $variant];
    $style = $height
        ? '--rai-stat-card-height: ' . (is_numeric($height) ? $height . 'px' : $height)
        : null;

    /*
     * One consistent icon API for every variant:
     * - iconSlot: primary visible icon
     * - actionIconSlot: action icon (accent-action)
     * - watermarkIconSlot: large decorative watermark (watermark)
     *
     * The plain `icon` prop remains a text/glyph fallback.
     */
    $hasIconSlot = isset($iconSlot);
    $hasActionIconSlot = isset($actionIconSlot);
    $hasWatermarkIconSlot = isset($watermarkIconSlot);

    if (! in_array($trendVariant, ['success', 'info', 'neutral', 'warning', 'danger'], true)) {
        throw new \InvalidArgumentException('Unsupported stat-card trend variant: ' . $trendVariant);
    }

    if (! in_array($iconVariant, ['primary', 'info', 'success', 'warning'], true)) {
        throw new \InvalidArgumentException('Unsupported stat-card icon variant: ' . $iconVariant);
    }
@endphp
<{{ $tag }}
    @if(filled($href)) href="{{ $href }}" @endif
    {{ $attributes->class($classes)->merge(['style' => $style]) }}
>
    @if($variant === 'split')
        <div class="rai-stat-card__top">
            <span class="rai-stat-card__icon">
                @if($hasIconSlot){{ $iconSlot }}@elseif(filled($icon)){{ $icon }}@else<span aria-hidden="true">▣</span>@endif
            </span>
            @if(filled($badge))<span class="rai-stat-card__badge">{{ $badge }}</span>@endif
        </div>
        @if(filled($title))<div class="rai-stat-card__label">{{ $title }}</div>@endif
        @if(! is_null($value))<div class="rai-stat-card__value">{{ $value }}</div>@endif
        @if(filled($primaryLabel) || ! is_null($primaryValue) || filled($secondaryLabel) || ! is_null($secondaryValue))
            <div class="rai-stat-card__split">
                <div>
                    @if(filled($primaryLabel))<span>{{ $primaryLabel }}</span>@endif
                    @if(! is_null($primaryValue))<strong>{{ $primaryValue }}</strong>@endif
                </div>
                <div>
                    @if(filled($secondaryLabel))<span>{{ $secondaryLabel }}</span>@endif
                    @if(! is_null($secondaryValue))<strong>{{ $secondaryValue }}</strong>@endif
                </div>
            </div>
        @endif

    @elseif($variant === 'revenue')
        <div class="rai-stat-card__revenue-head">
            <div class="rai-stat-card__revenue-copy">
                @if(filled($title))<div class="rai-stat-card__label">{{ $title }}</div>@endif
                @if(! is_null($value))<div class="rai-stat-card__value">{{ $value }}</div>@endif
            </div>
            <span class="rai-stat-card__icon">
                @if($hasIconSlot){{ $iconSlot }}@elseif(filled($icon)){{ $icon }}@else<span aria-hidden="true">$</span>@endif
            </span>
        </div>
        @if(filled($trend) || filled($trendLabel))
            <div class="rai-stat-card__trend">
                @if(filled($trend))<span>{{ $trend }}</span>@endif
                @if(filled($trendLabel)){{ $trendLabel }}@endif
            </div>
        @endif

    @elseif($variant === 'accent-action')
        <span class="rai-stat-card__accent"></span>
        <div class="rai-stat-card__accent-copy">
            @if(filled($title))<div class="rai-stat-card__label">{{ $title }}</div>@endif
            @if(! is_null($value))<div class="rai-stat-card__value">{{ $value }}</div>@endif
        </div>
        <span class="rai-stat-card__action" aria-hidden="true">
            @if($hasActionIconSlot){{ $actionIconSlot }}@elseif(filled($icon)){{ $icon }}@else↓@endif
        </span>

    @elseif($variant === 'icon-block')
        <span class="rai-stat-card__icon rai-stat-card__icon--block">
            @if($hasIconSlot){{ $iconSlot }}@elseif(filled($icon)){{ $icon }}@else<span aria-hidden="true">+</span>@endif
        </span>
        <div class="rai-stat-card__icon-copy">
            @if(filled($title))<div class="rai-stat-card__label">{{ $title }}</div>@endif
            @if(! is_null($value))<div class="rai-stat-card__value">{{ $value }}</div>@endif
        </div>

    @elseif($variant === 'compact')
        <div class="rai-stat-card__compact-head">
            @if(filled($title))<div class="rai-stat-card__label">{{ $title }}</div>@endif
            <span class="rai-stat-card__compact-arrow" aria-hidden="true">›</span>
        </div>
        @if(! is_null($value))<div class="rai-stat-card__value">{{ $value }}</div>@endif

    @elseif($variant === 'dashboard')
        <div class="rai-stat-card__dashboard-top">
            <span class="rai-stat-card__icon rai-stat-card__icon--{{ $iconVariant }}">
                @if($hasIconSlot)
                    {{ $iconSlot }}
                @elseif(filled($icon))
                    <x-admin-ui::icon :name="$icon" size="19" />
                @else
                    <span aria-hidden="true">▣</span>
                @endif
            </span>
            @if(filled($trend))
                <span class="rai-stat-card__dashboard-trend rai-stat-card__dashboard-trend--{{ $trendVariant }}">{{ $trend }}</span>
            @endif
        </div>
        @if(filled($title))<h3 class="rai-stat-card__label">{{ $title }}</h3>@endif
        @if(! is_null($value))<p class="rai-stat-card__value">{{ $value }}</p>@endif
        @if(filled($primaryLabel) || ! is_null($primaryValue) || filled($secondaryLabel) || ! is_null($secondaryValue))
            <div class="rai-stat-card__dashboard-footer">
                <div>
                    @if(filled($primaryLabel))<span>{{ $primaryLabel }}</span>@endif
                    @if(! is_null($primaryValue))<strong>{{ $primaryValue }}</strong>@endif
                </div>
                <div>
                    @if(filled($secondaryLabel))<span>{{ $secondaryLabel }}</span>@endif
                    @if(! is_null($secondaryValue))<strong>{{ $secondaryValue }}</strong>@endif
                </div>
            </div>
        @endif

    @elseif($variant === 'watermark')
        <div class="rai-stat-card__watermark" aria-hidden="true">
            @if($hasWatermarkIconSlot){{ $watermarkIconSlot }}@elseif(filled($icon)){{ $icon }}@else◌@endif
        </div>
        <div class="rai-stat-card__watermark-head">
            <span class="rai-stat-card__icon">
                @if($hasIconSlot){{ $iconSlot }}@elseif(filled($icon)){{ $icon }}@else<span aria-hidden="true">◌</span>@endif
            </span>
            @if(filled($trend) || filled($trendLabel))
                <span class="rai-stat-card__trend-badge">
                    @if(filled($trend)){{ $trend }}@endif
                    @if(filled($trendLabel)){{ $trendLabel }}@endif
                </span>
            @endif
        </div>
        @if(filled($title))<div class="rai-stat-card__label">{{ $title }}</div>@endif
        @if(! is_null($value))<div class="rai-stat-card__value">{{ $value }}</div>@endif
    @endif

    @isset($footer)<div class="rai-stat-card__footer">{{ $footer }}</div>@endisset
</{{ $tag }}>
