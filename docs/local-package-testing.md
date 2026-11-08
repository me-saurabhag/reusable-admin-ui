# GitHub package testing in a fresh Laravel host

Use a separate, fresh Laravel 13 application for this test. Do not reuse the local path repository for this phase.

## 1. Add the VCS repository

Merge this entry into the host application's root `composer.json` under `repositories`:

```json
{
    "type": "vcs",
    "url": "https://github.com/me-saurabhag/reusable-admin-ui"
}
```

Install the current `main` branch before a stable release is tagged:

```bash
composer require reusable-admin-ui/framework:dev-main@dev
```

## 2. Publish package files

```bash
php artisan vendor:publish --tag=admin-ui-config
php artisan vendor:publish --tag=admin-ui-assets
php artisan vendor:publish --tag=admin-ui-core
php artisan vendor:publish --tag=admin-ui-auth
```

Publish `admin-ui-core` before `admin-ui-auth`. Do not use `--force` on the first install.

## 3. Configure Vite

Import Bootstrap 5, the published Admin UI CSS, auth CSS, and any optional component CSS from `resources/css/app.css`. Import Bootstrap's bundle, `vendor/admin-ui/admin-ui.js`, and the published Login, Registration, and Forgot Password page classes from `resources/js/app.js`. Keep the host application's existing Tailwind directives and source declarations.

Build the host assets:

```bash
npm install
npm run build
php artisan optimize:clear
```

## 4. Verify the pages

Open `/login`, `/register`, and `/forgot-password`. Confirm there is no Vite manifest exception, CSS is present, Bootstrap controls work, dialogs render, and the browser console has no missing-module errors.

The package supplies GET presentation pages only. The host application remains responsible for form endpoints, validation, authentication, registration, OTP verification, and password reset.
