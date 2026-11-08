@props([
    'title' => 'Dashboard',
    'subtitle' => null,
    'profileName' => 'Administrator',
    'profileRole' => 'Admin',
    'profileInitials' => 'AD',
    'profileAvatar' => null,
    'cardData' => [],
])

@php
    $headerConfig = config('admin-ui.header.components', []);
    $cardsConfig = config('admin-ui.header.info_cards', []);
    $icon = function (string $name): string {
        $paths = [
            'search' => '<circle cx="11" cy="11" r="7"></circle><path d="m20 20-4-4"></path>',
            'grid' => '<rect x="4" y="4" width="6" height="6" rx="1"></rect><rect x="14" y="4" width="6" height="6" rx="1"></rect><rect x="4" y="14" width="6" height="6" rx="1"></rect><rect x="14" y="14" width="6" height="6" rx="1"></rect>',
            'plus' => '<path d="M12 5v14M5 12h14"></path>',
            'sun' => '<circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"></path>',
            'language' => '<circle cx="12" cy="12" r="9"></circle><path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18"></path>',
            'fullscreen' => '<path d="M8 3H5a2 2 0 0 0-2 2v3m13-5h3a2 2 0 0 1 2 2v3M3 16v3a2 2 0 0 0 2 2h3m13-5v3a2 2 0 0 1-2 2h-3"></path>',
            'message' => '<path d="M21 11.5a8.5 8.5 0 0 1-8.5 8.5 9 9 0 0 1-4-.9L3 21l1.9-5.5a9 9 0 0 1-.9-4A8.5 8.5 0 0 1 12.5 3H13a8.5 8.5 0 0 1 8 8v.5Z"></path>',
            'bell' => '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9m-8 12a2 2 0 0 0 4 0"></path>',
            'wallet' => '<rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M3 9h18m-5 5h2"></path>',
            'chevron' => '<path d="m7 10 5 5 5-5"></path>',
            'menu' => '<path d="M4 6h16M4 12h16M4 18h16"></path>',
            'user' => '<path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="8" r="4"></circle>',
            'settings' => '<circle cx="12" cy="12" r="3"></circle><path d="m19.4 15 .1.1 1.4 1.1-1.4 2.4-1.7-.7a8 8 0 0 1-1.8 1l-.3 1.8h-2.8l-.3-1.8a8 8 0 0 1-1.8-1l-1.7.7-1.4-2.4 1.4-1.1a8 8 0 0 1 0-2l-1.4-1.1 1.4-2.4 1.7.7a8 8 0 0 1 1.8-1l.3-1.8h2.8l.3 1.8a8 8 0 0 1 1.8 1l1.7-.7 1.4 2.4-1.4 1.1a8 8 0 0 1 0 2Z"></path>',
            'shield' => '<path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"></path><path d="m9 12 2 2 4-4"></path>',
            'help' => '<circle cx="12" cy="12" r="9"></circle><path d="M9.6 9a2.5 2.5 0 1 1 4.4 1.6c-1.2 1-2 1.4-2 3m0 3h.01"></path>',
            'logout' => '<path d="M10 17l5-5-5-5m5 5H3"></path><path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"></path>',
        ];
        return '<svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">'.$paths[$name] ?? $paths['grid'].'</svg>';
    };
@endphp

<div class="rai-header">
    <div class="rai-header__left">
        <button type="button" class="rai-header__menu" data-rai-sidebar-toggle aria-controls="rai-primary-sidebar" aria-expanded="false" aria-label="Toggle sidebar">{!! $icon('menu') !!}</button>
        <div class="rai-header__page-title">{{ $title }}</div>
        @if ($headerConfig['search'] ?? false)
            <button type="button" class="rai-header__search" data-rai-header-action="search">
                <span class="rai-header__search-icon">{!! $icon('search') !!}</span><span>Search here...</span><kbd>⌘K</kbd>
            </button>
        @endif
        @if (($headerConfig['explore'] ?? false) || ($headerConfig['apps'] ?? false))
            <div class="rai-header__nav-pills">
                @if ($headerConfig['explore'] ?? false)
                    <button type="button" class="rai-header__pill" data-rai-header-action="explore">{!! $icon('grid') !!}<span>Explore</span>{!! $icon('chevron') !!}</button>
                @endif
                @if ($headerConfig['apps'] ?? false)
                    <button type="button" class="rai-header__pill" data-rai-header-action="apps">{!! $icon('grid') !!}<span>Apps</span>{!! $icon('chevron') !!}</button>
                @endif
            </div>
        @endif
    </div>

    <div class="rai-header__right">
        @if ($headerConfig['quick_create'] ?? false)
            <button type="button" class="rai-header__quick-create" data-rai-header-action="quick_create">{!! $icon('plus') !!}<span>Quick Create</span>{!! $icon('chevron') !!}</button>
        @endif
        <div class="rai-header__icon-actions">
            @foreach (['theme_switcher' => ['sun', 'Theme'], 'language_switcher' => ['language', 'Language'], 'fullscreen' => ['fullscreen', 'Fullscreen'], 'messages' => ['message', 'Messages'], 'notifications' => ['bell', 'Notifications']] as $key => $item)
                @if ($headerConfig[$key] ?? false)
                    <button type="button" class="rai-header__icon-action" data-rai-header-action="{{ $key }}" aria-label="{{ $item[1] }}">{!! $icon($item[0]) !!}</button>
                @endif
            @endforeach
        </div>

        @if (($headerConfig['info_cards'] ?? false) && count($cardsConfig))
            <div class="rai-header__cards" data-rai-info-cards>
                @foreach ($cardsConfig as $key => $card)
                    @if ($card['enabled'] ?? false)
                        @php $value = data_get($cardData, $key.'.value', '—'); @endphp
                        <div class="rai-header__info-card" data-rai-info-card="{{ $key }}">
                            <span class="rai-header__card-icon">{!! $icon($card['icon'] ?? 'wallet') !!}</span>
                            <span class="rai-header__card-copy">
                                <span class="rai-header__card-label">{{ $card['label'] ?? $key }}</span>
                                <strong class="rai-header__card-value" data-rai-card-value>{{ is_scalar($value) ? $value : '—' }}</strong>
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        @if ($headerConfig['profile'] ?? true)
            @php
                $profileMenu = config('admin-ui.header.profile_menu', []);
                $profileMenuItems = $profileMenu['items'] ?? [];
            @endphp
            <div class="rai-header__profile-wrap" data-rai-profile>
                <button type="button" class="rai-header__profile" data-rai-profile-toggle
                        aria-haspopup="true" aria-expanded="false" aria-controls="rai-profile-menu">
                    <span class="rai-header__avatar">@if($profileAvatar)<img src="{{ $profileAvatar }}" alt="">@else{{ $profileInitials }}@endif</span>
                    <span class="rai-header__profile-copy"><strong>{{ $profileName }}</strong><small>{{ $profileRole }}</small></span>
                    {!! $icon('chevron') !!}
                </button>

                @if ($profileMenu['enabled'] ?? true)
                    <div class="rai-profile-menu" id="rai-profile-menu" data-rai-profile-menu hidden>
                        @if ($profileMenu['show_user_details'] ?? true)
                            <div class="rai-profile-menu__identity">
                                <span class="rai-profile-menu__avatar">@if($profileAvatar)<img src="{{ $profileAvatar }}" alt="">@else{{ $profileInitials }}@endif</span>
                                <span class="rai-profile-menu__identity-copy">
                                    <strong>{{ $profileName }}</strong>
                                    <small>{{ $profileRole }}</small>
                                </span>
                            </div>
                        @endif

                        <div class="rai-profile-menu__items">
                            @foreach ($profileMenuItems as $key => $item)
                                @if ($item['enabled'] ?? false)
                                    @if ($item['divider_before'] ?? false)
                                        <div class="rai-profile-menu__divider" role="separator"></div>
                                    @endif
                                    <button type="button"
                                            class="rai-profile-menu__item {{ ($item['danger'] ?? false) ? 'is-danger' : '' }}"
                                            data-rai-profile-action="{{ $key }}">
                                        <span class="rai-profile-menu__item-icon">{!! $icon($item['icon'] ?? 'grid') !!}</span>
                                        <span>{{ $item['label'] ?? $key }}</span>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
