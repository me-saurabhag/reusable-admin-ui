<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    @if (filled(config('admin-ui.favicon')))
        <link rel="icon" href="{{ config('admin-ui.favicon') }}">
    @endif

    @if (config('admin-ui.assets.include_bootstrap', true))
        <link rel="stylesheet" href="{{ asset(config('admin-ui.assets.bootstrap_css')) }}">
    @endif

    @vite($authCss ?? config('admin-ui.auth.vite.css', 'resources/css/app.css'))

    @stack('styles')
</head>
<body class="rai-auth-body">
    @yield('content')
    @stack('scripts')
    @include('admin-ui::dialogs.status-dialog')
    @if (config('admin-ui.auth.otp_dialog.enabled', true))
        @include('admin-ui::dialogs.otp-modal')
    @endif

    @vite($authJs ?? config('admin-ui.auth.vite.js', 'resources/js/app.js'))
</body>
</html>
