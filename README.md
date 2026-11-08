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

Install the stable release:

```bash
composer require reusable-admin-ui/framework:^0.1
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

```css
/* resources/css/app.css */
@import './vendor/admin-ui/admin-ui.css';
@import './vendor/admin-ui/sidebar-logo.css';
@import './vendor/admin-ui/sidebar-variants.css';
@import './vendor/admin-ui/main-header-alignment.css';
```

```js
// resources/js/app.js
import './vendor/admin-ui/admin-ui.js';
```

Authentication styles and page classes should be added to the host application's Vite inputs when those pages are used. The exact entry-point list belongs to the host application. Then run its normal commands:

```bash
npm install
npm run dev
# or
npm run build
```

Bootstrap is supplied by the host. The package layout can include its local Bootstrap files by default; if the host already loads Bootstrap, set `assets.include_bootstrap` to `false` in `config/admin-ui.php` to avoid loading it twice.

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

Publish `config/admin-ui.php` and customize its values for the host application. Important defaults include:

- `theme.default`: `light`
- `layout.sidebar`: `classic`
- `auth.login`: `v1`
- `assets.include_bootstrap`: `true`

The package can register GET presentation routes for `/login`, `/register`, and `/forgot-password`. These routes are enabled by default in the package configuration. If the host application already owns these routes, disable the corresponding package routes to prevent route overlap:

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

- `BasePage.js` — page lifecycle, DOM helpers, event-listener cleanup, header/profile action hooks, and optional Toast/Loader integration.
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
