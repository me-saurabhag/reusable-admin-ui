# Login V1 integration

## Responsibility boundary

The package owns the reusable login presentation: Blade markup, CSS, and configurable copy/branding/links. The host Laravel application owns `LoginPage.js`, the authentication endpoint, API client, validation, OTP/session flows, redirects, and all application-specific behavior.

## Publish the host LoginPage.js starter

```bash
php artisan vendor:publish --tag=admin-ui-auth
```

The command creates `resources/js/pages/LoginPage.js` in the host application. It extends the host's `BasePage`, handles password visibility, and emits a cancelable `admin-ui:login-submit` event. Add your own authentication implementation in this host file or listen for that event from another host module.

```js
document.addEventListener('admin-ui:login-submit', async (event) => {
    event.preventDefault();

    const { email, password, formData, form } = event.detail;

    // Host-owned code only:
    // - validate fields
    // - call your ApiClient or submit to your own endpoint
    // - handle OTP, sessions, errors and redirects
});
```

Calling `event.preventDefault()` cancels the native form POST. If no listener cancels the event, the browser submits the form normally to `auth.login_page.action` (or the current login URL when action is null).

## Handling JSON login responses in the host application

The package does not parse or prescribe your API response. The host application listens for `admin-ui:login-submit`, cancels the native form POST synchronously, sends the request, and handles the JSON according to its own API contract.

Example for a Laravel endpoint that returns JSON:

```js
document.addEventListener('admin-ui:login-submit', async (event) => {
    // Must happen before the first await so the native form POST is cancelled.
    event.preventDefault();

    const { form, formData } = event.detail;
    const page = window.adminUiLoginPage;

    try {
        const response = await fetch(form.action, {
            method: form.method.toUpperCase(),
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            body: formData,
        });

        const result = await response.json();

        if (response.ok && result.success) {
            page.toast.success(result.message || 'Login successful');

            if (result.redirect) {
                window.location.assign(result.redirect);
            }

            return;
        }

        page.toast.error(result.message || 'Unable to sign in');

        // Optional: map Laravel validation errors to your own field UI.
        if (result.errors) {
            console.log('Login validation errors:', result.errors);
        }
    } catch (error) {
        console.error(error);
        page.toast.error('A network or server error occurred. Please try again.');
    }
});
```

The example expects a response such as `{ "success": true, "message": "Login successful", "redirect": "/dashboard" }`. This is only an example contract; change the conditions and property names to match your API. Laravel's normal session-based login can instead use the native form POST and redirect response without this AJAX listener.

## Social login feedback

Configured social provider links show an informational toast before navigating to the configured provider URL. If a provider has no URL, its button remains clickable and displays a warning toast explaining that the provider is not configured. The provider URL and OAuth implementation remain host-application responsibilities.

## Routes and configuration

The package registers a GET route using `auth.route.path`, which defaults to `/login`. Set it to `/` if desired. If the host application already defines that GET route, set `auth.route.enabled` to `false` and render `admin-ui::auth.login.v1` from the host route/controller instead.

The host application must register the POST endpoint or configure `auth.login_page.action` to point to it. The form method and input names are configurable.

The design is selected by `auth.login` (`v1`, `v2`, `v3`, or `v4`). Shared logos are configured under `auth.branding`; shared visible text, forgot-password/register links, and social providers are configured under `auth.login_page`. Optional per-variant overrides live under `auth.variants.{variant}.branding` and `auth.variants.{variant}.login_page`. All variants preserve the same form IDs and Host JS hooks. See `auth-login-variants.md` for the complete design and demo reference.

## Stable integration hooks

All Login variants must preserve these IDs so the host implementation does not need to change when the design changes:

- `#loginForm`
- `#emailAddress`
- `#password`
- `#btnLogin`
- `#signInWithGoogle`

Password visibility uses `[data-password-toggle]` and `[data-password-input]`.
