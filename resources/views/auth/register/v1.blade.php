
@extends('admin-ui::layouts.auth')

@php
    $variant = $registrationVariant ?? config('admin-ui.auth.registration.variant', 'v1');

    $defaults = config('admin-ui.auth.registration', []);
    $variantConfig = $defaults['variants'][$variant] ?? [];

    $registration = array_replace(
        $defaults,
        array_diff_key($variantConfig, ['branding' => true])
    );

    $branding = array_replace(
        $defaults['branding'] ?? [],
        $variantConfig['branding'] ?? []
    );

    $fields = $registration['fields'] ?? [];

    // Registration must load its own Host Vite entrypoints, not the login assets.
    $authCss = $registration['vite']['css'] ?? [
        'resources/css/app.css',
        'resources/css/pages/auth/register.css',
    ];
    $authJs = $registration['vite']['js'] ?? [
        'resources/js/app.js',
        'resources/js/pages/RegisterPage.js',
    ];

    // Demo mode is explicitly passed by the demo controller.
    $demoMode = $demoMode ?? false;
@endphp

@section('title', $registration['title'] ?? 'Create Account')

@section('content')

<main
    class="rai-auth-register rai-auth-register--{{ $variant }}"
    data-admin-ui-page="auth-register"
    data-admin-ui-variant="{{ $variant }}"
    data-demo-mode="{{ $demoMode ? 'true' : 'false' }}"
>
    <div class="container-fluid p-0 h-100">
        <div class="row g-0 auth-row">

            {{-- LEFT PANEL --}}
            <section class="col-lg-6 d-none d-lg-flex left-panel">

                <div class="left-panel-content">

                    @if(filled($branding['logo_on_dark'] ?? null))
                        <div class="brand">
                            <img
                                src="{{ $branding['logo_on_dark'] }}"
                                alt="{{ $branding['logo_alt'] ?? '' }}"
                                class="brand-logo-full"
                            >
                        </div>
                    @endif

                    <h1 class="headline">
                        {{ $registration['headline'] ?? '' }}<br>
                        <span class="brand-accent">
                            {{ $registration['headline_accent'] ?? '' }}
                        </span>
                    </h1>

                    <p class="subtext">
                        {{ $registration['description'] ?? '' }}
                    </p>

                    <div class="feature-list">

                        <div class="feature-item d-flex">
                            <div class="feature-icon" aria-hidden="true">✦</div>
                            <div>
                                <h2 class="feature-title mb-1">A Connected Workspace</h2>
                                <p class="feature-desc mb-0">
                                    Bring your people, tools and daily work together.
                                </p>
                            </div>
                        </div>

                        <div class="feature-item d-flex">
                            <div class="feature-icon" aria-hidden="true">✓</div>
                            <div>
                                <h2 class="feature-title mb-1">Simple to Get Started</h2>
                                <p class="feature-desc mb-0">
                                    Create your account and configure your workspace.
                                </p>
                            </div>
                        </div>

                        <div class="feature-item d-flex">
                            <div class="feature-icon" aria-hidden="true">◇</div>
                            <div>
                                <h2 class="feature-title mb-1">Built to Grow</h2>
                                <p class="feature-desc mb-0">
                                    A flexible platform that grows with your needs.
                                </p>
                            </div>
                        </div>

                    </div>

                    <p class="copyright">
                        {{ str_replace(':year', date('Y'), $registration['copyright'] ?? '') }}
                    </p>

                </div>
            </section>

            {{-- RIGHT PANEL --}}
            <section class="col-lg-6 right-panel d-flex align-items-center justify-content-center">

                <div class="form-card">

                    {{-- HEADER --}}
                    <div class="text-center mb-3">

                        @if(filled($branding['logo_on_light'] ?? null))
                            <div class="login-logo-frame">
                                <img
                                    src="{{ $branding['logo_on_light'] }}"
                                    alt="{{ $branding['logo_alt'] ?? '' }}"
                                    class="welcome-logo mb-2"
                                >
                            </div>
                        @endif

                        <h2 class="welcome-title mb-1">
                            {{ $registration['welcome_title'] ?? 'Create Your Account' }}
                        </h2>

                        <p class="welcome-sub mb-0">
                            {{ $registration['welcome_description'] ?? '' }}
                        </p>

                    </div>

                    {{-- DEMO NOTICE --}}
                    @if($demoMode)
                        <div class="alert alert-info py-2 small">
                            Preview mode — registration is not connected.
                        </div>
                    @endif

                    {{-- VALIDATION ERRORS --}}
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- REGISTRATION FORM --}}
                    <form
                        id="registrationForm"
                        data-registration-form
                        action="{{ $registration['action'] ?? request()->url() }}"
                        method="{{ strtoupper($registration['method'] ?? 'POST') === 'GET' ? 'GET' : 'POST' }}"
                    >

                        @if(strtoupper($registration['method'] ?? 'POST') !== 'GET')
                            @csrf
                        @endif

                        {{-- NAME, EMAIL AND REFERRAL FIELDS --}}
                        @foreach(['name', 'email'] as $fieldKey)

                            @php
                                $field = $fields[$fieldKey] ?? [];
                                $fieldEnabled = $field['enabled'] ?? false;
                                $fieldRequired = $field['required'] ?? false;
                                $fieldName = $field['name'] ?? $fieldKey;

                                $inputType = match($fieldKey) {
                                    'email' => 'email',
                                    default => 'text',
                                };
                            @endphp

                            @if($fieldEnabled && $fieldKey !== 'mobile')

                                <div class="mb-3">

                                    <label
                                        for="register-{{ $fieldKey }}"
                                        class="form-label field-label"
                                    >
                                        {{ $field['label'] ?? ucfirst($fieldKey) }}
                                    </label>

                                    <div class="input-group custom-input-group">

                                        <input
                                            type="{{ $inputType }}"
                                            class="form-control custom-input"
                                            id="register-{{ $fieldKey }}"
                                            name="{{ $fieldName }}"
                                            value="{{ old($fieldName) }}"
                                            placeholder="{{ $field['placeholder'] ?? '' }}"
                                            @if($fieldRequired) required @endif
                                            @if($fieldKey === 'name')
                                                maxlength="255"
                                                autocomplete="name"
                                            @elseif($fieldKey === 'email')
                                                autocomplete="email"
                                            @endif
                                        >

                                        <span class="input-group-text custom-input-icon" aria-hidden="true">
                                            {{ $fieldKey === 'email' ? '✉' : ($fieldKey === 'name' ? '♙' : '⌁') }}
                                        </span>

                                    </div>
                                </div>

                            @endif

                        @endforeach

                        {{-- MOBILE FIELD --}}
                        @php
                            $mobile = $fields['mobile'] ?? [];
                            $countryCode = $fields['country_code'] ?? [];
                        @endphp

                        @if($mobile['enabled'] ?? false)

                            <div class="mb-3">

                                <label
                                    for="register-mobile"
                                    class="form-label field-label"
                                >
                                    {{ $mobile['label'] ?? 'Mobile Number' }}
                                </label>

                                <div class="input-group custom-input-group mobile-number-group">

                                    @if($countryCode['enabled'] ?? false)

                                        <select
                                            class="form-select country-code-select"
                                            id="register-country-code"
                                            name="{{ $countryCode['name'] ?? 'countryCode' }}"
                                            aria-label="{{ $countryCode['label'] ?? 'Country Code' }}"
                                        >
                                            <option value="">
                                                {{ $countryCode['placeholder'] ?? 'Code' }}
                                            </option>

                                            <option value="+91">IN (+91)</option>
                                            <option value="+1">US (+1)</option>
                                            <option value="+44">UK (+44)</option>
                                        </select>

                                    @endif

                                    <input
                                        type="tel"
                                        class="form-control custom-input mobile-number-input"
                                        id="register-mobile"
                                        name="{{ $mobile['name'] ?? 'mobileNumber' }}"
                                        value="{{ old($mobile['name'] ?? 'mobileNumber') }}"
                                        maxlength="15"
                                        placeholder="{{ $mobile['placeholder'] ?? '' }}"
                                        @if($mobile['required'] ?? false) required @endif
                                        autocomplete="tel-national"
                                    >

                                </div>
                            </div>

                        @endif

                        {{-- REFERRAL CODE (OPTIONAL) — kept as the last field --}}
                        @php
                            $referral = $fields['referral'] ?? [];
                            $referralName = $referral['name'] ?? 'refCode';
                        @endphp

                        @if($referral['enabled'] ?? false)
                            <div class="mb-3">
                                <label
                                    for="register-referral"
                                    class="form-label field-label"
                                >
                                    {{ $referral['label'] ?? 'Referral Code (Optional)' }}
                                </label>

                                <div class="input-group custom-input-group">
                                    <input
                                        type="text"
                                        class="form-control custom-input"
                                        id="register-referral"
                                        name="{{ $referralName }}"
                                        value="{{ old($referralName) }}"
                                        placeholder="{{ $referral['placeholder'] ?? 'Enter referral code' }}"
                                        @if($referral['required'] ?? false) required @endif
                                        autocomplete="off"
                                    >

                                    <span class="input-group-text custom-input-icon" aria-hidden="true">⌁</span>
                                </div>
                            </div>
                        @endif

                        {{-- SUBMIT BUTTON --}}
                        <button
                            type="button"
                            id="btnRegister"
                            class="btn btn-signin w-100 mb-4"
                        >
                            {{ $registration['submit_label'] ?? 'Create Account' }}
                        </button>

                    </form>

                    {{-- LOGIN LINK --}}
                    <p class="text-center signup-text mb-0">

                        {{ $registration['login_prompt'] ?? 'Already have an account?' }}

                        <a
                            href="{{ $registration['login_url'] ?? '/login' }}"
                            class="signup-link"
                        >
                            {{ $registration['login_label'] ?? 'Sign In' }}
                        </a>

                    </p>

                </div>

            </section>

        </div>
    </div>
</main>

@endsection

