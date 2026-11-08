# Laravel Demo Application

This Laravel 13 application is the integration host and visual test harness for the Reusable Admin UI Framework package in the repository root.

## Requirements

- PHP 8.3+
- Composer 2+
- Node.js 22+ and npm
- SQLite (used by the automated test suite)

## Fresh setup

Run these commands from the `demo/` directory:

```bash
composer install
npm ci

# Create a local environment only when one does not already exist.
[ -f .env ] || cp .env.example .env
php artisan key:generate

# Publish the package files required by this demo.
php artisan vendor:publish --tag=admin-ui-assets --force
php artisan vendor:publish --tag=admin-ui-core --force
php artisan vendor:publish --tag=admin-ui-auth --force

npm run build
php artisan optimize:clear
php artisan test
php artisan serve
```

Do not overwrite an existing `.env`. The demo already includes its configured `config/admin-ui.php`; for a new application, publish the config without `--force` and merge defaults into any existing customization manually.

Open the URL printed by Artisan. Useful demo pages include:

- `/admin/demo/dashboard` — dashboard hero, WhatsApp CRM metrics, messaging chart, and conversation/automation health.
- `/admin-ui/components` — component variants.
- `/admin-ui/buttons`, `/admin-ui/form-inputs`, `/admin-ui/input-groups`, `/admin-ui/tags-pills`, `/admin-ui/radio-checkbox`, `/admin-ui/dropdowns`, `/admin-ui/accordions`, `/admin-ui/lists`, `/admin-ui/statistics-cards`, and `/admin-ui/tables` — component showcases.
- `/admin-ui/auth` and `/admin-ui/auth/*` — authentication design previews.

For local development, run `npm run dev` instead of `npm run build`.

## Package source

The demo's Composer path repository points to `..`, the repository root. This is intentional: the root itself is the installable Composer package, while this directory is only the host/demo application. The demo does not include a generated `composer.lock`; the first `composer install` resolves the local path package and creates a lock file for that checkout.

## Tests

Run the Laravel feature and unit tests with:

```bash
php artisan test
```

The tests assume the package files have been published as shown in the setup steps above.
