@props([
    'title' => config('app.name', 'Laravel'),
    'theme' => null,
])

@php
    $activeTheme = config('admin-ui.theme.default', 'light');
    $allowRuntimeOverride = (bool) config('admin-ui.theme.allow_runtime_override', true);
    if ($allowRuntimeOverride && filled($theme)) {
        if (! in_array($theme, ['light'], true)) {
            throw new \InvalidArgumentException(sprintf('Unsupported runtime theme "%s". Supported themes: light.', (string) $theme));
        }
        $activeTheme = $theme;
    }
    $includeBootstrap = (bool) config('admin-ui.assets.include_bootstrap', true);
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    @if (filled(config('admin-ui.favicon')))
        <link rel="icon" href="{{ config('admin-ui.favicon') }}">
    @endif
    @if ($includeBootstrap)
        <link rel="stylesheet" href="{{ asset(config('admin-ui.assets.bootstrap_css')) }}">
    @endif

    {{-- Shared styles and runtime --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

    {{-- Page-specific CSS and optional head assets --}}
    @stack('admin-ui:styles')
    @stack('admin-ui:head')
</head>
<body>
<div class="rai-ui" data-rai-theme="{{ $activeTheme }}" data-rai-sidebar-preset="{{ config('admin-ui.layout.sidebar', 'classic') }}" data-rai-login-preset="{{ config('admin-ui.auth.login', 'centered') }}" data-rai-sidebar-open="false" data-rai-sidebar-collapsed="{{ config('admin-ui.sidebar.default_collapsed', true) ? 'true' : 'false' }}">
    <div class="rai-ui__shell">
        @isset($sidebar)
            <aside class="rai-ui__sidebar" id="rai-primary-sidebar">{{ $sidebar }}</aside>
        @endisset

        <div class="rai-ui__main">
            @isset($header)
                <header class="rai-ui__header{{ config('admin-ui.header.sticky', false) ? ' rai-ui__header--sticky' : '' }}">{{ $header }}</header>
            @endisset

            <main class="rai-ui__content">{{ $slot }}</main>

            @isset($footer)
                <footer class="rai-ui__footer">{{ $footer }}</footer>
            @endisset
        </div>
    </div>

    <button type="button" class="rai-ui__mobile-backdrop" data-rai-sidebar-close aria-label="Close navigation"></button>
</div>

@if ($includeBootstrap)
    <script src="{{ asset(config('admin-ui.assets.bootstrap_js')) }}" defer></script>
@endif

{{-- Page-specific JavaScript is loaded after shared runtime assets. --}}
@stack('admin-ui:scripts')
</body>
</html>
