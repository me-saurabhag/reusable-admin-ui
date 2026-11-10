@props([
    // Host application may pass its menu structure via :sections="$menu".
    'sections' => config('admin-ui.sidebar.sections', []),
    'brandName' => config('app.name', 'Admin UI'),
    'brandUrl' => url('/'),
    'brandLogo' => 'https://admin.pixelstrap.net/mofi/assets/images/logo/logo_light.png',
    'brandLogoSmall' => 'https://admin.pixelstrap.net/mofi/assets/images/logo/logo-icon.png',
])
<div class="rai-ui__sidebar-inner">
    <div class="rai-ui__sidebar-brand-wrap">
        @if (isset($brand) && $brand->isNotEmpty())
            <div class="rai-ui__sidebar-brand-content">{{ $brand }}</div>
        @else
            <a class="rai-ui__sidebar-brand" href="{{ $brandUrl }}" aria-label="{{ $brandName }} home">
                <img
                    class="rai-ui__brand-logo rai-ui__brand-logo-full"
                    src="{{ $brandLogo }}"
                    alt="{{ $brandName }}"
                >
                <img
                    class="rai-ui__brand-logo rai-ui__brand-logo-small"
                    src="{{ $brandLogoSmall }}"
                    alt=""
                    aria-hidden="true"
                >
            </a>
        @endif
    </div>

    <nav class="rai-ui__nav" aria-label="Primary navigation">
        @if (! empty($sections))
            @foreach ($sections as $sectionIndex => $section)
                @php
                    $sectionItems = $section['items'] ?? [];
                    $sectionLabel = $section['label'] ?? $section['section'] ?? null;
                @endphp
                @if ($sectionLabel)
                    <div class="rai-ui__nav-label">{{ $sectionLabel }}</div>
                @endif
                @foreach ($sectionItems as $itemIndex => $item)
                    @php
                        $children = $item['children'] ?? [];
                        $hasChildren = count($children) > 0;
                        $itemId = 'rai-nav-' . $sectionIndex . '-' . $itemIndex;
                        $routeName = $item['route'] ?? null;
                        $href = $item['url'] ?? (($routeName && \Illuminate\Support\Facades\Route::has($routeName)) ? route($routeName) : '#');
                        $active = (bool) ($item['active'] ?? false);
                        if (! $active && $routeName && \Illuminate\Support\Facades\Route::has($routeName)) {
                            $active = request()->routeIs($routeName) || request()->routeIs($routeName . '.*');
                        }
                        foreach ($children as $child) {
                            $childRoute = $child['route'] ?? null;
                            $childRouteActive = $childRoute
                                && \Illuminate\Support\Facades\Route::has($childRoute)
                                && (request()->routeIs($childRoute) || request()->routeIs($childRoute . '.*'));
                            if (! empty($child['active']) || $childRouteActive) {
                                $active = true;
                            }
                        }
                        $label = $item['label'] ?? 'Menu';
                        $tooltip = $item['tooltip'] ?? $label;
                        $icon = $item['icon'] ?? 'stroke-layout';
                        $icon = is_string($icon) && preg_match('/^[a-z0-9-]+$/', $icon) ? $icon : 'stroke-layout';
                    @endphp
                    @if ($hasChildren)
                        <div class="rai-ui__nav-group{{ $active ? ' is-active' : '' }}" data-rai-nav-group>
                            <button type="button" class="rai-ui__nav-link rai-ui__nav-parent{{ $active ? ' is-active' : '' }}" data-rai-submenu-toggle data-rai-tooltip="{{ $tooltip }}" title="{{ $tooltip }}" aria-expanded="{{ $active ? 'true' : 'false' }}" aria-controls="{{ $itemId }}">
                                <span class="rai-ui__nav-icon" aria-hidden="true"><svg class="rai-ui__nav-icon-svg" viewBox="0 0 24 24" focusable="false"><use href="{{ asset('vendor/admin-ui/icons.svg') }}#{{ $icon }}"></use></svg></span>
                                <span class="rai-ui__nav-text">{{ $label }}</span>
                                <span class="rai-ui__nav-chevron" aria-hidden="true">⌄</span>
                            </button>
                            <div class="rai-ui__submenu" id="{{ $itemId }}" @if (! $active) hidden @endif>
                                @foreach ($children as $child)
                                    @php
                                        $childRoute = $child['route'] ?? null;
                                        $childHref = $child['url'] ?? (($childRoute && \Illuminate\Support\Facades\Route::has($childRoute)) ? route($childRoute) : '#');
                                        $childActive = (bool) ($child['active'] ?? false);
                                        $childIcon = $child['icon'] ?? 'stroke-layout';
                                        $childIcon = is_string($childIcon) && preg_match('/^[a-z0-9-]+$/', $childIcon) ? $childIcon : 'stroke-layout';
                                        if (! $childActive && $childRoute && \Illuminate\Support\Facades\Route::has($childRoute)) {
                                            $childActive = request()->routeIs($childRoute) || request()->routeIs($childRoute . '.*');
                                        }
                                    @endphp
                                    <a href="{{ $childHref }}" class="rai-ui__nav-link rai-ui__nav-child{{ $childActive ? ' is-active' : '' }}" @if ($childActive) aria-current="page" @endif>
                                        <span class="rai-ui__nav-icon rai-ui__nav-child-icon" aria-hidden="true"><svg class="rai-ui__nav-icon-svg" viewBox="0 0 24 24" focusable="false"><use href="{{ asset('vendor/admin-ui/icons.svg') }}#{{ $childIcon }}"></use></svg></span>
                                        <span class="rai-ui__nav-text">{{ $child['label'] ?? 'Submenu' }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $href }}" class="rai-ui__nav-link{{ $active ? ' is-active' : '' }}" title="{{ $tooltip }}" @if ($active) aria-current="page" @endif>
                            <span class="rai-ui__nav-icon" aria-hidden="true"><svg class="rai-ui__nav-icon-svg" viewBox="0 0 24 24" focusable="false"><use href="{{ asset('vendor/admin-ui/icons.svg') }}#{{ $icon }}"></use></svg></span>
                            <span class="rai-ui__nav-text">{{ $label }}</span>
                        </a>
                    @endif
                @endforeach
            @endforeach
        @else
            {{ $slot }}
        @endif
    </nav>
</div>
