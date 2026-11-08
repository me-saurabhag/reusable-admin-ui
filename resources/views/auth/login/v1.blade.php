@extends('admin-ui::layouts.auth')

@php
    // All four visual variants share one markup contract and the same Host JS hooks.
    $loginVariant = $loginVariant ?? config('admin-ui.auth.login', 'v1');
    $variantConfig = config("admin-ui.auth.variants.{$loginVariant}", []);
    // Use shallow replacement so variant feature/social-login lists replace
    // the defaults completely instead of merging numeric array entries.
    $branding = array_replace(
        config('admin-ui.auth.branding', []),
        $variantConfig['branding'] ?? []
    );
    $login = array_replace(
        config('admin-ui.auth.login_page', []),
        $variantConfig['login_page'] ?? []
    );
    $features = $login['features'] ?? [];
    $formAction = $login['action'] ?? request()->url();
    $formMethod = strtoupper($login['method'] ?? 'POST');
    $emailName = $login['email_name'] ?? 'emailAddress';
    $passwordName = $login['password_name'] ?? 'password';
    $showSocialLogins = $login['show_social_logins'] ?? true;
    $showRegisterLink = $login['show_register_link'] ?? true;
    $demoMode = $demoMode ?? false;
@endphp

@section('title', $login['title'] ?? config('app.name', 'Sign In'))

@section('content')
    <main class="rai-auth-login-v1 rai-auth-login--{{ $loginVariant }}" data-admin-ui-page="auth-login-v1" data-admin-ui-variant="{{ $loginVariant }}" data-demo-mode="{{ $demoMode ? 'true' : 'false' }}">
        <div class="container-fluid p-0 h-100">
            <div class="row g-0 auth-row">
                {{-- LEFT PANEL --}}
                <section class="col-lg-6 d-none d-lg-flex left-panel" aria-label="{{ $login['brand_panel_label'] ?? 'About' }}">
                    <div class="left-panel-content">
                        <div class="brand">
                            @if (filled($branding['logo_on_dark'] ?? null))
                                <img src="{{ $branding['logo_on_dark'] }}"
                                     alt="{{ $branding['logo_alt'] ?? config('app.name') }}"
                                     class="brand-logo-full">
                            @endif
                        </div>

                        <h1 class="headline">
                            {{ $login['headline'] ?? 'Manage Conversations.' }}<br>
                            <span class="brand-accent">{{ $login['headline_accent'] ?? 'Delight Customers.' }}</span>
                        </h1>

                        <p class="subtext">{{ $login['description'] ?? 'The all-in-one WhatsApp CRM to connect, engage and grow your business.' }}</p>

                        @if (! empty($features))
                            <div class="feature-list">
                                @foreach ($features as $feature)
                                    <div class="feature-item d-flex">
                                        <div class="feature-icon" aria-hidden="true">
                                            @if (filled($feature['icon'] ?? null))
                                                <x-admin-ui::icon :name="$feature['icon']" size="22" />
                                            @endif
                                        </div>
                                        <div>
                                            <h2 class="feature-title mb-1">{{ $feature['title'] ?? '' }}</h2>
                                            <p class="feature-desc mb-0">{{ $feature['description'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <p class="copyright">{{ str_replace(':year', date('Y'), $login['copyright'] ?? '© :year All rights reserved.') }}</p>
                    </div>
                </section>

                {{-- RIGHT PANEL --}}
                <section class="col-lg-6 right-panel d-flex align-items-center justify-content-center">
                    <div class="form-card">
                        <div class="text-center mb-3">
                            @if (filled($branding['logo_on_light'] ?? null))
                                <div class="login-logo-frame">
                                    <img src="{{ $branding['logo_on_light'] }}"
                                         alt="{{ $branding['logo_alt'] ?? config('app.name') }}"
                                         class="welcome-logo mb-2">
                                </div>
                            @endif
                            @if (filled($login['welcome_title'] ?? null))
                                <h2 class="welcome-title mb-1">{{ $login['welcome_title'] }}</h2>
                            @endif
                            @if (filled($login['welcome_description'] ?? null))
                                <p class="welcome-sub mb-0">{{ $login['welcome_description'] }}</p>
                            @endif
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success" role="status">{{ session('status') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="loginForm" data-login-form
                              action="{{ $formAction }}"
                              method="{{ $formMethod === 'GET' ? 'GET' : 'POST' }}">
                            @if ($formMethod !== 'GET')
                                @csrf
                            @endif

                            <div class="mb-3">
                                <label for="emailAddress" class="form-label field-label">{{ $login['email_label'] ?? 'Email Address' }}</label>
                                <div class="input-group custom-input-group">
                                    <input type="email"
                                           class="form-control custom-input {{ $errors->has($emailName) ? 'is-invalid' : '' }}"
                                           id="emailAddress"
                                           name="{{ $emailName }}"
                                           value="{{ old($emailName) }}"
                                           placeholder="{{ $login['email_placeholder'] ?? 'Enter Registered Email' }}"
                                           autocomplete="username"
                                           required
                                           autofocus>
                                    <span class="input-group-text custom-input-icon" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/>
                                            <path stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label field-label">{{ $login['password_label'] ?? 'Password' }}</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text custom-input-icon border-end-0 order-first" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24">
                                            <rect width="16" height="11" x="4" y="10" stroke="currentColor" stroke-width="1.8" rx="2"/>
                                            <path stroke="currentColor" stroke-width="1.8" d="M7 10V7a5 5 0 0 1 10 0v3"/>
                                        </svg>
                                    </span>
                                    <input type="password"
                                           class="form-control custom-input border-start-0 ps-0 {{ $errors->has($passwordName) ? 'is-invalid' : '' }}"
                                           id="password"
                                           name="{{ $passwordName }}"
                                           placeholder="{{ $login['password_placeholder'] ?? 'Enter your password' }}"
                                           autocomplete="current-password"
                                           data-password-input
                                           required>
                                    <button type="button"
                                            class="input-group-text custom-input-icon toggle-password"
                                            data-password-toggle
                                            aria-label="Show password"
                                            aria-pressed="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="text-end mb-4">
                                @if (filled($login['forgot_password_url'] ?? null))
                                    <a href="{{ $login['forgot_password_url'] }}" class="forgot-link">{{ $login['forgot_password_label'] ?? 'Forgot Password?' }}</a>
                                @endif
                            </div>

                            <button type="submit" id="btnLogin" class="btn btn-signin w-100 mb-4">
                                {{ $login['submit_label'] ?? 'Sign In' }}
                            </button>
                        </form>

                        @php
                            // Keep google_url supported for applications using the earlier config.
                            $socialLogins = $login['social_logins'] ?? [];
                            $legacyGoogleUrl = $login['google_url'] ?? null;

                            // Honour google_url from older published host configs.
                            if (filled($legacyGoogleUrl)) {
                                $googleIndex = array_search('google', array_column($socialLogins, 'provider'), true);
                                if ($googleIndex === false) {
                                    $socialLogins[] = [
                                        'provider' => 'google',
                                        'label' => $login['google_label'] ?? 'Sign in with Google',
                                        'url' => $legacyGoogleUrl,
                                        'enabled' => true,
                                    ];
                                } elseif (empty($socialLogins[$googleIndex]['url'])) {
                                    $socialLogins[$googleIndex]['url'] = $legacyGoogleUrl;
                                }
                            }

                            $socialLogins = array_values(array_filter(
                                $socialLogins,
                                fn ($provider) => ($provider['enabled'] ?? true) === true
                            ));
                        @endphp

                        @if ($showSocialLogins && ! empty($socialLogins))
                            <div class="social-login-section">
                                <div class="divider mb-3"><span>{{ $login['divider_label'] ?? 'or' }}</span></div>
                                <div class="social-login-list">
                                    @foreach ($socialLogins as $provider)
                                        @php
                                            $providerName = strtolower($provider['provider'] ?? 'social');
                                            $providerUrl = $provider['url'] ?? null;
                                            $providerLabel = $provider['label'] ?? 'Continue with ' . ucfirst($providerName);
                                        @endphp

                                        @php
                                            $socialAttributes = [
                                                'data-social-login' => 'true',
                                                'data-social-provider' => ucfirst($providerName),
                                                'data-social-configured' => filled($providerUrl) ? 'true' : 'false',
                                                'data-social-pending-message' => $login['social_login_pending_message'] ?? 'Connecting to :provider...',
                                                'data-social-unavailable-message' => $login['social_login_unavailable_message'] ?? ':provider login is not configured yet.',
                                            ];
                                        @endphp

                                        @if (filled($providerUrl))
                                            <a
                                                @if ($providerName === 'google') id="signInWithGoogle" @endif
                                                href="{{ $providerUrl }}"
                                                class="btn btn-social-login w-100 d-flex align-items-center justify-content-center"
                                                @foreach ($socialAttributes as $attribute => $value) {{ $attribute }}="{{ $value }}" @endforeach
                                            >
                                        @else
                                            <button
                                                @if ($providerName === 'google') id="signInWithGoogle" @endif
                                                type="button"
                                                class="btn btn-social-login w-100 d-flex align-items-center justify-content-center"
                                                @foreach ($socialAttributes as $attribute => $value) {{ $attribute }}="{{ $value }}" @endforeach
                                            >
                                        @endif
                                            @if ($providerName === 'google')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48" class="me-2" aria-hidden="true">
                                                    <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.6 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.6 6 29.6 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.5Z"/>
                                                    <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.6 16 19 13 24 13c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.6 6 29.6 4 24 4 16.3 4 9.7 8.3 6.3 14.7Z"/>
                                                    <path fill="#4CAF50" d="M24 44c5.5 0 10.4-1.9 14.3-5.1l-6.6-5.6C29.6 35 26.9 36 24 36c-5.3 0-9.7-3.4-11.3-8l-6.6 5.1C9.6 39.6 16.2 44 24 44Z"/>
                                                    <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.3 4.3-4.2 5.7l6.6 5.6C41.9 36.6 44 30.8 44 24c0-1.3-.1-2.7-.4-3.5Z"/>
                                                </svg>
                                            @endif
                                            {{ $providerLabel }}
                                        @if (filled($providerUrl))
                                            </a>
                                        @else
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($showRegisterLink && filled($login['register_url'] ?? null))
                            <div class="signup-section text-center">
                                <p class="signup-text mb-0">
                                    {{ $login['register_prompt'] ?? "Don't have an account?" }}
                                    <a href="{{ $login['register_url'] }}" class="signup-link">{{ $login['register_label'] ?? 'Create Account' }}</a>
                                </p>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection
