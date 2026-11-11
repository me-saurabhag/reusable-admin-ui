# Header Profile Menu

The Header profile menu is presentation-only. Each item can optionally navigate to a named Laravel route owned by the Host Application.

## Configuration

Edit the Host Application's published `config/admin-ui.php`:

```php
'header' => [
    'profile_menu' => [
        'enabled' => true,
        'show_user_details' => true,
        'items' => [
            'my_profile' => [
                'enabled' => true,
                'label' => 'My Profile',
                'icon' => 'user',
                'route' => 'web.profile',
                'method' => 'GET',
                'divider_before' => false,
            ],
            'account_settings' => [
                'enabled' => true,
                'label' => 'Account Settings',
                'icon' => 'settings',
                'route' => 'web.account.settings',
                'method' => 'GET',
                'divider_before' => false,
            ],
            'security' => [
                'enabled' => true,
                'label' => 'Security & Privacy',
                'icon' => 'shield',
                'route' => 'web.security',
                'method' => 'GET',
                'divider_before' => false,
            ],
            'help_center' => [
                'enabled' => true,
                'label' => 'Help Center',
                'icon' => 'help',
                'route' => 'web.help',
                'method' => 'GET',
                'divider_before' => false,
            ],
            'logout' => [
                'enabled' => true,
                'label' => 'Sign Out',
                'icon' => 'logout',
                'route' => 'web.logout',
                'method' => 'POST',
                'divider_before' => true,
                'danger' => true,
            ],
        ],
    ],
],
```

Use your application's actual route names. The names above are examples.

## Supported methods

| Method | Rendering | Use |
| --- | --- | --- |
| `GET` | Anchor link | Open a page |
| `POST` | HTML form with CSRF token | Submit an action |
| `PUT`, `PATCH`, `DELETE` | POST form with CSRF token and Laravel method spoofing | Update or delete a resource |

For state-changing actions such as logout, use a non-GET method. Laravel's `@csrf` token is included automatically; PUT/PATCH/DELETE are sent using Laravel's hidden `_method` field.

## Host Application routes

Define the routes in the Host Application. For example:

```php
use Illuminate\\Support\\Facades\\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('web.profile');

    Route::get('/account/settings', [AccountSettingsController::class, 'index'])
        ->name('web.account.settings');

    Route::get('/security', [SecurityController::class, 'index'])
        ->name('web.security');

    Route::get('/help', [HelpController::class, 'index'])
        ->name('web.help');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('web.logout');
});
```

Your controller and middleware names may differ. Keep authentication, authorization, session invalidation, and redirects in the Host Application.

## Logout redirect route

Set the named route the Host Application should use after logout in the published `config/admin-ui.php`:

```php
'auth' => [
    'logout_redirect_route' => 'admin-ui.login',
],
```

The package does not perform logout or redirect automatically. Read this setting in the Host logout controller after invalidating the session:

```php
return redirect()->route(config('admin-ui.auth.logout_redirect_route', 'admin-ui.login'));
```

Use a route name that exists in the Host Application. If the Host owns its login route, set that route name instead.

## Fallback behavior

- If `route` is `null`, empty, or the named route is not registered, the item remains a button and emits the existing `admin-ui:profile-action` event with the item key in its `data-rai-profile-action` attribute.
- This preserves event-driven integrations for menu actions that are handled by Host JavaScript.
- Only `GET`, `POST`, `PUT`, `PATCH`, and `DELETE` are accepted. An unsupported method falls back to the event button.
- Set `enabled` to `false` to hide an item.

## Notes

- Route names must exist in the Host Application; the package does not register profile, settings, security, help, or logout routes.
- The package checks whether the named route exists before generating its URL. It does not perform authorization checks.
- Do not use GET routes for actions that change server-side state.
