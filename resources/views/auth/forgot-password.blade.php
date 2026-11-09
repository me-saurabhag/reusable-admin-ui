@extends('admin-ui::layouts.auth')

@php
    $forgot = config('admin-ui.auth.forgot_password', []);
    $branding = $forgot['branding'] ?? [];
    $demoMode = $demoMode ?? false;

    // These are entrypoints from the Host application's Vite manifest.
    $authCss = $forgot['vite']['css'] ?? 'resources/css/app.css';
    $authJs = $forgot['vite']['js'] ?? 'resources/js/app.js';

    $formMethod = strtoupper($forgot['method'] ?? 'POST');
    $formMethod = $formMethod === 'GET' ? 'GET' : 'POST';
    $formAction = $forgot['action'] ?? request()->url();

    $passwordFields = [
        [
            'key' => 'password',
            'name' => $forgot['password_name'] ?? 'password',
            'label' => $forgot['password_label'] ?? 'New Password',
            'placeholder' => $forgot['password_placeholder'] ?? 'Enter new password',
            'autocomplete' => 'new-password',
        ],
        [
            'key' => 'password_confirmation',
            'name' => $forgot['password_confirmation_name'] ?? 'password_confirmation',
            'label' => $forgot['password_confirmation_label'] ?? 'Re-Type Password',
            'placeholder' => $forgot['password_confirmation_placeholder'] ?? 'Re-enter new password',
            'autocomplete' => 'new-password',
        ],
    ];
@endphp

@section('title', $forgot['title'] ?? 'Reset Password')

@section('content')
<main
    class="rai-auth-forgot"
    data-admin-ui-page="auth-forgot-password"
    data-demo-mode="{{ $demoMode ? 'true' : 'false' }}"
>
    <section class="forgot-card">

        @if(filled($branding['logo'] ?? null))
            <div class="forgot-logo">
                <img
                    src="{{ $branding['logo'] }}"
                    alt="{{ $branding['logo_alt'] ?? 'Application Logo' }}"
                >
            </div>
        @endif

        <div class="text-center mb-4">
            <h1>{{ $forgot['title'] ?? 'Reset Your Password' }}</h1>
            <p>{{ $forgot['description'] ?? 'Enter your email and choose a new password for your account.' }}</p>
        </div>

        @if($demoMode)
            <div class="alert alert-info small py-2" role="status">
                Preview mode — password reset is not connected.
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            id="forgotPasswordForm"
            data-forgot-password-form
            action="{{ $formAction }}"
            method="{{ $formMethod }}"
        >
            @if($formMethod !== 'GET')
                @csrf
            @endif

            <div class="mb-3">
                <label class="form-label" for="forgot-email">
                    {{ $forgot['email_label'] ?? 'Email Address' }}
                </label>

                <div class="forgot-input-wrap">
                    <input
                        class="form-control"
                        type="email"
                        id="forgot-email"
                        name="{{ $forgot['email_name'] ?? 'email' }}"
                        value="{{ old($forgot['email_name'] ?? 'email') }}"
                        placeholder="{{ $forgot['email_placeholder'] ?? 'Enter your registered email' }}"
                        autocomplete="email"
                        required
                    >
                </div>
            </div>

            @foreach($passwordFields as $field)
                <div class="mb-3">
                    <label class="form-label" for="forgot-{{ $field['key'] }}">
                        {{ $field['label'] }}
                    </label>

                    <div class="forgot-input-wrap">
                        <input
                            class="form-control"
                            type="password"
                            id="forgot-{{ $field['key'] }}"
                            name="{{ $field['name'] }}"
                            placeholder="{{ $field['placeholder'] }}"
                            autocomplete="{{ $field['autocomplete'] }}"
                            minlength="8"
                            required
                            data-password-input
                        >

                        <button
                            type="button"
                            data-password-toggle
                            aria-label="Show password"
                            aria-pressed="false"
                        >
                            Show
                        </button>
                    </div>
                </div>
            @endforeach

            <button
                class="btn btn-primary w-100"
                id="btnForgotPassword"
                type="button"
            >
                {{ $forgot['submit_label'] ?? 'Update Password' }}
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ $forgot['login_url'] ?? '/login' }}">
                ← {{ $forgot['login_label'] ?? 'Back to Sign In' }}
            </a>
        </div>

    </section>
</main>
@endsection
