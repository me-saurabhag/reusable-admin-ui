# Reusable Admin UI Framework

A presentation-only Laravel package providing reusable Blade components, a responsive admin shell, authentication page layouts, dashboard widgets, and small browser-side utilities.

## Requirements

- PHP 8.3 or newer
- Laravel 13
- Bootstrap 5 (provided by the host application)
- Vite in the host application to compile the published CSS and JavaScript

The package itself has no NPM package, Node build, React, database, or application-specific business-logic dependency.

## Install from GitHub

Add the repository to the host application's `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/me-saurabhag/reusable-admin-ui"
        }
    ]
}
```

For the current GitHub `main` branch (pre-release testing):

```bash
composer require reusable-admin-ui/framework:dev-main@dev
```

After a stable `0.2.x` release has been tagged, install it with:

```bash
composer require reusable-admin-ui/framework:^0.2
```

Laravel package auto-discovery registers `ReusableAdminUi\AdminUiServiceProvider`.

## Install package assets

After Composer has installed the package, run the installer:

```bash
php artisan admin-ui:install
npm install bootstrap
npm run build
```

Bootstrap is a host-application dependency. Install it after the Admin UI installer and before building the Vite assets. If Bootstrap is already listed in the host application's dependencies, running `npm install bootstrap` again is safe.

The installer publishes the package configuration (only when it does not already exist), frontend assets, shared utilities, and missing authentication starter files. It also creates the required host-side auth CSS entry files, registers the authentication CSS/JS entries in the standard Laravel Vite `input: []` array, and adds the package's shared shell runtime import to `resources/js/app.js`.

The command is designed to be safe to run again: existing Vite entries and CSS imports are not duplicated, and existing Host config and authentication starter files are never overwritten. It adds Bootstrap CSS and the package's global CSS imports to `resources/css/app.css` while preserving existing Tailwind directives and Host CSS. Package-managed copies under `resources/css/vendor/admin-ui` and `resources/js/vendor/admin-ui` are refreshed only when `--force` is supplied.

> **Update rule:** use `php artisan admin-ui:install --force` only to refresh package-managed files under `resources/css/vendor/admin-ui` and `resources/js/vendor/admin-ui`. It does not overwrite `config/admin-ui.php`, page starter files, page CSS wrappers, `vite.config.js`, or `resources/js/app.js`. Do not customize files inside the `vendor/admin-ui` resource folders; put application-specific changes in your own files.

The focused publish tags remain available when you only need to refresh one part of the package: `admin-ui-config`, `admin-ui-assets`, `admin-ui-core`, `admin-ui-auth`, `admin-ui-dialogs`, `admin-ui-otp-dialog`, `admin-ui-inputs`, `admin-ui-pagination`, and `admin-ui-offcanvas`.

## Updating an existing Host Application

Use the same update sequence in every Laravel project that uses this package:

```bash
composer update reusable-admin-ui/framework
php artisan admin-ui:install --force
npm run build
```

For projects tracking the GitHub development branch, Composer must already have the VCS repository configured and the package constraint must allow `dev-main`. For released projects, keep a stable version constraint (for example, `^0.2`) and update within that allowed range.

The update command has a deliberate ownership boundary:

- Composer owns the code under `vendor/reusable-admin-ui/framework`.
- The package installer refreshes only package-managed published copies under `resources/css/vendor/admin-ui` and `resources/js/vendor/admin-ui` when `--force` is supplied.
- Host-owned configuration, page entry wrappers, page starter JavaScript, `vite.config.js`, and `resources/js/app.js` are not force-overwritten.
- Put custom application styles and behavior in separate Host files; do not edit files inside the published `vendor/admin-ui` resource folders.

New components are delivered by the Composer package. If a component adds a new Host Vite entry or requires a Host layout integration, that change must be included in the installer and documented as part of the same release. Package releases should be tested against both a clean Laravel host and an existing host with previously published config/assets before tagging.

## Vite integration

The host application owns its Vite configuration and imports the published package assets. Typical imports are:

Global `resources/css/app.css` should contain only shared/global styles. Do not import Login, Registration, or Forgot Password page styles there. Each page imports its own stylesheet through the dedicated entry published by `admin-ui-auth`.

```css
/* resources/css/app.css */
@import './vendor/admin-ui/admin-ui.css';
@import './vendor/admin-ui/sidebar-logo.css';
@import './vendor/admin-ui/sidebar-variants.css';
@import './vendor/admin-ui/main-header-alignment.css';
@import './vendor/admin-ui/components/toast.css';
@import './vendor/admin-ui/components/loader.css';

/* Do not import OTP or Status Dialog styles globally.
   Import each component stylesheet only from pages that render that dialog. */
```

```js
// resources/js/app.js — global runtime only
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import './vendor/admin-ui/admin-ui.js';

// Do not import page-specific modules in this global entry.
```

Each authentication page has its own Vite entries. For authenticated Admin pages, push page CSS and JavaScript into the shared layout's `admin-ui:styles` and `admin-ui:scripts` stacks (example below). The shared `app.js` must
contain only global runtime code and must never import LoginPage, RegisterPage,
ForgotPasswordPage, DashboardPage, or other page modules.

The `admin-ui:install` command creates the starter page modules and matching
CSS entry files under `resources/css/pages/auth/`, then adds their entries to
the host `vite.config.js`. You do not need to create these wrappers or add the
three authentication entries manually. Keep page-specific auth stylesheet
imports out of global `resources/css/app.css`.

The resulting Vite input array contains:

```js
laravel({
    input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/pages/auth/login.css',
        'resources/js/pages/LoginPage.js',
        'resources/css/pages/auth/register.css',
        'resources/js/pages/RegisterPage.js',
        'resources/css/pages/auth/forgot-password.css',
        'resources/js/pages/ForgotPasswordPage.js',
    ],
    refresh: true,
})
```

The package auth layouts load the global entries plus only their own page
entries. Login loads LoginPage, registration loads RegisterPage, and
forgot-password loads ForgotPasswordPage. For future admin pages, create a
dedicated JS/CSS entry, add it to Vite input, and include only those entries
in that page's Blade layout. Vite may extract shared dependencies into common
chunks; unrelated page modules are still not executed.


### Post-Login Base Layout

The package provides `admin-ui::layouts.app` as the shared layout for authenticated Admin pages. It renders the package Header, Sidebar, and content shell. Host pages extend this layout instead of rebuilding the shell:

```blade
{{-- resources/views/admin/dashboard/index.blade.php --}}
@extends('admin-ui::layouts.app')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard')

@push('admin-ui:styles')
    @vite('resources/css/pages/admin/dashboard.css')
@endpush

@section('content')
    <div class="rai-page-heading">
        <h1>Dashboard</h1>
    </div>

    {{-- Dashboard content --}}
@endsection

@push('admin-ui:scripts')
    @vite('resources/js/pages/admin/DashboardPage.js')
@endpush
```

The Host Application supplies the permission-filtered menu through its own `AdminMenuProvider` and `AdminLayoutComposer`. Register the composer against the package layout in the Host Application's `AppServiceProvider`:

```php
use App\\Presentation\\Admin\\ViewComposers\\AdminLayoutComposer;
use Illuminate\\Support\\Facades\\View;

public function boot(): void
{
    View::composer('admin-ui::layouts.app', AdminLayoutComposer::class);
}
```

The composer should pass the menu array as `menu`; the package only renders it and never evaluates user permissions. The Host Application can also pass optional `headerData` (profile fields and header info-card values) from its controller or another view composer.

The shared layout loads global `app.css`/`app.js`, page CSS in the document head, and page JavaScript immediately before `</body>`. Set `header.sticky` to `true` in `config/admin-ui.php` to make the post-login header stick to the top while scrolling; it defaults to `false`. Add each future Admin page's CSS and JS entry to the Host Vite input list. Authentication pages share both Status and OTP Dialog markup through `admin-ui::layouts.auth` (OTP markup can be disabled with `auth.otp_dialog.enabled`). Login, Registration, and Forgot Password each load their own page CSS/JS entry; each authentication CSS entry includes both dialog styles. The authenticated `admin-ui::layouts.app` never inserts either dialog. A post-login Host page opts in by including the required Blade partial and importing the matching CSS/JS from that page's own assets.

Then install Bootstrap if it is not already installed, and run the frontend build:

```bash
npm install bootstrap
npm run build
```

For local development, use `npm run dev` instead of `npm run build`. Bootstrap is supplied by the host. The package defaults `assets.include_bootstrap` to `false`; the host application
is responsible for loading Bootstrap. Set it to `true` only if the package
layout should load valid public Bootstrap files and the host does not load it.

## Minimal Blade example

```blade
<x-admin-ui::layout title="Admin UI example">
    <div class="container py-4">
        <h1 class="h3 mb-3">Admin UI foundation</h1>

        <div class="d-flex flex-wrap gap-2 mb-4">
            <x-admin-ui::button-primary type="button">Save changes</x-admin-ui::button-primary>
            <x-admin-ui::button-outline type="button">Cancel</x-admin-ui::button-outline>
            <x-admin-ui::badge-success>Active</x-admin-ui::badge-success>
        </div>

        <div class="col-12 col-md-6">
            <x-admin-ui::input-outlined
                name="email"
                label="Email address"
                type="email"
                help="Use your work email address."
                required
            />
        </div>
    </div>
</x-admin-ui::layout>
```

## Design Tokens and Brand Customization

The framework exposes CSS variables for the primary/secondary brand palette,
semantic colors, page surfaces, text, borders, typography and spacing. Override
these tokens in the Host Application instead of editing package-managed CSS.
For example, add the following at the bottom of `resources/css/app.css`:

```css
:root {
    --rai-primary: #2457a6;
    --rai-primary-hover: #1d4788;
    --rai-primary-active: #17396d;
    --rai-primary-soft: #eaf0fb;
    --rai-primary-contrast: #ffffff;
    --rai-focus-ring: #2457a6;
}
```

The shared `--rai-*` tokens apply to Admin UI components that consume them.
Authentication pages can also have page-scoped accent variables; for example,
Login V1 uses `--wa-green`. Keep such overrides in the Host page CSS wrapper,
not in `resources/css/vendor/admin-ui/`.

See [Design Tokens and Host Theme Overrides](docs/design-tokens.md) for the
full token categories, examples for secondary/status/sidebar colors,
typography and spacing, and the separate Login accent override.

## Dashboard components

The package includes reusable dashboard presentation components for a hero section, messaging activity chart, conversation/automation health, and dashboard statistic cards. See [Dashboard Components](docs/dashboard-components.md) for the Blade APIs, expected data, and examples. The package renders supplied values; the host application remains responsible for retrieving and preparing real data.

## Configuration and authentication routes

Publish `config/admin-ui.php` and customize its values for the host application. The top-level `favicon` setting controls the browser tab icon in both the package Admin and authentication layouts. Set it to another image URL to use your own icon, or set it to `null`/an empty value to omit the favicon link. Important defaults include:

- `theme.default`: `light`
- `layout.sidebar`: `classic`
- `auth.login`: `v1`
- `auth.logout_redirect_route`: `admin-ui.login` (named route for the Host logout controller to redirect to after logout)
- `header.sticky`: `false` (set to `true` to keep the post-login header visible while scrolling)
- `favicon`: `https://bot.kotfumes.com/assets/app/images/chatbot.webp` (shared Admin and Auth browser tab icon)
- `assets.include_bootstrap`: `false` (the host application supplies Bootstrap)

Example favicon override in the host application's `config/admin-ui.php`:

```php
'favicon' => 'https://example.com/images/favicon.png',
```

The package can register GET presentation routes for `/login`, `/register`, and `/forgot-password`. These routes are enabled by default and use Laravel's `guest` middleware so an already-authenticated user is not shown a guest authentication page. This applies to all three package-owned auth routes.

The middleware is configurable through `auth.guest_middleware` in the published `config/admin-ui.php`. Keep the default `guest`, provide your own middleware class/name (or an array of middleware), or set it to `null` to disable the additional guest middleware. Existing per-route `middleware` settings are preserved and combined with this setting. For example, a host with custom authentication guards can use its own middleware:

```php
'auth' => [
    'guest_middleware' => \\App\\Http\\Middleware\\RedirectAuthenticatedUser::class,
],
```

When using Laravel's built-in `guest` middleware, configure the authenticated-user destination in the host application's Laravel bootstrap/authentication configuration (for example, `/dashboard`). The package does not decide the host application's dashboard route.

If the host application already owns these routes, disable the corresponding package routes to prevent route overlap:

```php
// config/admin-ui.php
'auth' => [
    'route' => ['enabled' => false],
    'registration' => [
        'route' => ['enabled' => false],
    ],
    'forgot_password' => [
        'route' => ['enabled' => false],
    ],
],
```

The package only renders the GET pages. The host application owns POST endpoints, authentication, authorization, validation, OTP verification, password reset, session handling, and redirects. The Host logout controller can read `config('admin-ui.auth.logout_redirect_route')` to choose its post-logout destination. Review the sample branding, logo URLs, labels, and copy in the published configuration before using them in a public-facing application.

## JavaScript utilities

The package publishes small ES modules for shared page behavior and optional components:

- `BasePage.js` — minimal page lifecycle, DOM helpers, event-listener cleanup, header/profile action hooks, reusable form helpers, Toast integration, and optional Loader integration. It does not import dialogs or the API client.
- `Toast.js` — lightweight success, info, warning, and error notifications; BasePage provides it as `this.toast` by default.
- `ApiClient.js` — a separate opt-in module. Import it only from pages that make API requests.
- `OtpManager.js` and `StatusDialog.js` — dialog utilities. Both are available on the three authentication pages; post-login pages import and render them only when required.
- `LocationManager.js` — browser geolocation service with explicit permission requests and normalized errors.
- Dialog, PIN input, pagination, and offcanvas utilities.

### Host-controlled form submission

The Forgot Password starter prepares the form and exposes common helpers directly
on the form element. The Host Application registers its own native `submit`
listener and decides what happens next (API request, OTP flow, server validation,
and response handling). Browser-native validation runs before the submit event.
The package does not listen for submission, dispatch a custom event, call an API,
or initialize the OTP dialog.

```js
const form = document.getElementById('forgotPasswordForm');

form?.addEventListener('submit', async (event) => {
    event.preventDefault();
    const values = form.getFormValues();

    try {
        form.setFormLoading(true);
        const response = await ApiClient.post('/forgot-password', values);
        // Handle the Host Application response here.
    } catch (error) {
        console.error(error);
    } finally {
        form.setFormLoading(false);
    }
});
```

Available form helpers:

- `form.getFormValues()` — plain object of named successful controls; repeated names become arrays.
- `form.getFormData()` — native FormData, useful for file or multipart requests.
- `form.getFieldValue(name)` — read one named control.
- `form.setFieldValue(name, value)` — set one named control.
- `form.clearForm()` — reset controls to their HTML default values.
- `form.setFormLoading(boolean)` — disable/enable the submit button and update its loading label.
These helpers are attached by the Forgot Password starter after initialization.
The Host Application should register its submit listener on the form and call
`form.getFormValues()` inside that listener. The Host Application initializes
and uses the separate OTP helper itself when needed. Login and Registration are
not changed by this update.


Location permission is never requested automatically. Request it only after an explicit user action. Browser geolocation requires a secure context (HTTPS, except localhost) and must not be treated as authoritative proof for security-sensitive authorization or geofencing.

Call `destroy()` on page instances when they are disposed so registered event listeners can be removed. See the implementation notes in `docs/` for component-specific usage.

## Header profile menu

Each Header profile menu item can be connected to a named route owned by the Host Application. Configure its `route` and HTTP `method` in `config/admin-ui.php`. See [Header Profile Menu](docs/header-profile-menu.md) for GET links, CSRF-protected state-changing requests, logout setup, and the fallback JavaScript event.

## SVG icon sprite

The package provides one external SVG symbol sprite at `resources/svg/icons.svg`. The `admin-ui-assets` publish tag copies it to `public/vendor/admin-ui/icons.svg`. Both authentication and post-login layouts, including the shared Icon component and Sidebar, reference symbols from this same external file using SVG `<use>` URLs. The browser can cache the sprite separately, so its full markup is not repeated in every page response. The public path is configurable through `admin-ui.assets.icon_sprite` (default: `vendor/admin-ui/icons.svg`). Add icons by defining new `<symbol>` elements in the package SVG file, then update the published Host copy when upgrading package assets.

## Responsibility boundary

The host application owns real data, database queries, controllers, business logic, validation, authentication, authorization, APIs, and persistence. This package owns presentation: Blade components, layout, scoped CSS, responsive primitives, and small UI interactions. It is not a CRUD engine or a data layer.

## Demo application

The interactive Laravel demo is maintained separately from this package repository. It can be installed and updated independently, without adding demo application dependencies to the package.

## License

MIT. See [LICENSE](LICENSE).


### Registration country selector

Configure selectable countries in `admin-ui.auth.registration.countries`. Each item contains `code` (calling code without `+`), `region` (country symbol), and `name`. Set `admin-ui.auth.registration.default_country` to the desired region; the default is `IN`. The package defaults include India, United States, and United Kingdom. The Host can replace or extend this list in its published configuration. The registration starter dispatches `admin-ui:register-submit` with `event.detail.request` containing `fullName`, `email`, `mobile`, `refCode`, `countryCode`, `regionCode`, and `geoLocation`; the existing `formData` and `otpDialog` properties remain available.
