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

## Publish package files

Publish the package configuration and frontend assets:

```bash
php artisan vendor:publish --tag=admin-ui-config
php artisan vendor:publish --tag=admin-ui-assets
```

If you use the shared page utilities (BasePage, LocationManager, dialogs, PIN input, pagination, or offcanvas), publish the core set:

```bash
php artisan vendor:publish --tag=admin-ui-core
```

If you want the package's starter authentication page classes copied into your host application, publish:

```bash
php artisan vendor:publish --tag=admin-ui-auth
```

The auth starter files import `BasePage` from `resources/js/vendor/admin-ui/core/BasePage.js`; publish `admin-ui-core` before building the auth entry points. Publishing starter files is optional if you manage your own page classes.

Other focused publish tags are available: `admin-ui-dialogs`, `admin-ui-otp-dialog`, `admin-ui-inputs`, `admin-ui-pagination`, and `admin-ui-offcanvas`. The `admin-ui-core` tag includes the shared dependencies for the full core utility set.

> **Overwrite warning:** add `--force` only when you intentionally want to replace files already published into your application. Review local changes first.

## Vite integration

The host application owns its Vite configuration and imports the published package assets. Typical imports are:

Global `resources/css/app.css` should contain only shared/global styles. Do not import Login, Registration, or Forgot Password page styles there. Each page imports its own stylesheet through the dedicated entry published by `admin-ui-auth`.

```css
/* resources/css/app.css */
@import './vendor/admin-ui/admin-ui.css';
@import './vendor/admin-ui/sidebar-logo.css';
@import './vendor/admin-ui/sidebar-variants.css';
@import './vendor/admin-ui/main-header-alignment.css';
@import './vendor/admin-ui/components/status-dialog.css';
@import './vendor/admin-ui/components/toast.css';
@import './vendor/admin-ui/components/loader.css';
@import './vendor/admin-ui/components/otp-dialog.css';
```

```js
// resources/js/app.js — global runtime only
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import './vendor/admin-ui/admin-ui.js';

// Do not import page-specific modules in this global entry.
```

Each authentication page has its own Vite entries. The shared `app.js` must
contain only global runtime code and must never import LoginPage, RegisterPage,
ForgotPasswordPage, DashboardPage, or other page modules.

Publish `admin-ui-auth` to create the starter page modules and their matching
CSS entry files under `resources/css/pages/auth/`. Keep page-specific auth
stylesheet imports out of global `resources/css/app.css`.

Add all entries to the host `vite.config.js`:

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

Then run its normal commands:

```bash
npm install
npm run dev
# or
npm run build
```

Bootstrap is supplied by the host. The package defaults `assets.include_bootstrap` to `false`; the host application
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

## Dashboard components

The package includes reusable dashboard presentation components for a hero section, messaging activity chart, conversation/automation health, and dashboard statistic cards. See [Dashboard Components](docs/dashboard-components.md) for the Blade APIs, expected data, and examples. The package renders supplied values; the host application remains responsible for retrieving and preparing real data.

## Configuration and authentication routes

Publish `config/admin-ui.php` and customize its values for the host application. The top-level `favicon` setting controls the browser tab icon in both the package Admin and authentication layouts. Set it to another image URL to use your own icon, or set it to `null`/an empty value to omit the favicon link. Important defaults include:

- `theme.default`: `light`
- `layout.sidebar`: `classic`
- `auth.login`: `v1`
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

The package only renders the GET pages. The host application owns POST endpoints, authentication, authorization, validation, OTP verification, password reset, session handling, and redirects. Review the sample branding, logo URLs, labels, and copy in the published configuration before using them in a public-facing application.

## JavaScript utilities

The package publishes small ES modules for shared page behavior and optional components:

- `BasePage.js` — page lifecycle, DOM helpers, event-listener cleanup, header/profile action hooks, and optional Loader integration.
- `Toast.js` — lightweight success, info, warning, and error notifications; BasePage provides it as `this.toast` by default.
- `LocationManager.js` — browser geolocation service with explicit permission requests and normalized errors.
- Dialog, PIN input, pagination, and offcanvas utilities.

Location permission is never requested automatically. Request it only after an explicit user action. Browser geolocation requires a secure context (HTTPS, except localhost) and must not be treated as authoritative proof for security-sensitive authorization or geofencing.

Call `destroy()` on page instances when they are disposed so registered event listeners can be removed. See the implementation notes in `docs/` for component-specific usage.

## SVG icon sprite

The package layout includes the SVG sprite once as a hidden inline symbol set. Sidebar menu items pass a symbol ID such as `stroke-layout`, `stroke-user`, or `stroke-chat`. Add icons by defining new `<symbol>` elements in `resources/views/components/icon-sprite.blade.php` and referencing their IDs.

## Responsibility boundary

The host application owns real data, database queries, controllers, business logic, validation, authentication, authorization, APIs, and persistence. This package owns presentation: Blade components, layout, scoped CSS, responsive primitives, and small UI interactions. It is not a CRUD engine or a data layer.

## Demo application

The interactive Laravel demo is maintained separately from this package repository. It can be installed and updated independently, without adding demo application dependencies to the package.

## License

MIT. See [LICENSE](LICENSE).


### Registration country selector

Configure selectable countries in `admin-ui.auth.registration.countries`. Each item contains `code` (calling code without `+`), `region` (country symbol), and `name`. Set `admin-ui.auth.registration.default_country` to the desired region; the default is `IN`. The package defaults include India, United States, and United Kingdom. The Host can replace or extend this list in its published configuration. The registration starter dispatches `admin-ui:register-submit` with `event.detail.request` containing `fullName`, `email`, `mobile`, `refCode`, `countryCode`, `regionCode`, and `geoLocation`; the existing `formData` and `otpDialog` properties remain available.
