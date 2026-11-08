# Authentication Login V1 — Implementation Update

## Package responsibilities

The package owns the Login V1 presentation only:

- Blade markup and scoped CSS.
- Configurable logos, page copy, links, field names, and form action/method.
- The configured GET route that renders the selected Login design.

The package does not contain authentication APIs, validation, OTP, session handling, social-auth processing, or redirects.

## Host application responsibilities

The host application owns:

- `LoginPage.js` and all login submission behavior.
- API client usage, validation, OTP/session flows, redirects, and error handling.
- The POST route/controller or custom endpoint configured as `auth.login_page.action`.
- Shared page utilities such as `BasePage`, `LocationManager`, and `UIManager`.

## Publish the host-side starter

After installing the package, run:

```bash
php artisan vendor:publish --tag=admin-ui-auth
```

This publishes the starter to `resources/js/pages/LoginPage.js`. It extends the host application's `BasePage`, toggles password visibility, and dispatches a cancelable `admin-ui:login-submit` event. If no listener cancels the event, the browser performs a normal HTML form submission.

Example host-side AJAX hook:

```js
document.addEventListener('admin-ui:login-submit', async (event) => {
    event.preventDefault();

    const { email, password, formData, form } = event.detail;

    // Add your own validation and authentication implementation here.
    // Example: await ApiClient.post('/your-login-endpoint', { email, password });
});
```

The package does not provide `ApiClient` or any of the host application's business classes.

## Configuration

Configure `config/admin-ui.php` under `auth`:

- `login`: selected UI variant (`v1` is available in this release).
- `route.enabled`: enable/disable the package GET route.
- `route.path`: `/login` or `/`; disable the package route if the host already owns that GET route.
- `branding.logo_on_dark`, `branding.logo_on_light`, and `branding.logo_alt`.
- `login_page`: text content, field names, form action/method, forgot-password URL, registration URL, and social login providers.
- `vite.css` and `vite.js`: host Vite manifest entry paths.

The package registers only the configured GET page route. The host application must register the matching POST route or set `login_page.action` to its own endpoint.

## Stable UI hooks

Login V1 preserves the original integration IDs:

- `#loginForm`
- `#emailAddress`
- `#password`
- `#btnLogin`
- `#signInWithGoogle`

The password visibility button also retains `[data-password-toggle]` and the input retains `[data-password-input]`. Future Login variants must keep these integration hooks stable and change presentation only.

## Vite entries

The host Vite manifest includes:

- `resources/css/auth-login-v1.css`
- `resources/js/pages/LoginPage.js`

The auth layout loads only these page-specific entries, not the host dashboard `app.js` entry.

## BasePage and browser location

The demo host application's `BasePage` exposes Toast and browser-location helpers. Location permission is opt-in: pages call `requestLocation()` only when required. Opening the Login page does not automatically ask for browser location permission.

The supplied workspace does not contain a `Loader.js` implementation, so `BasePage.loader` is an optional host integration point (`window.AdminUiLoader`) until that file is added.
