# Login design variants V1–V4

All four Login designs use one shared Blade renderer and one stable form contract. Selecting a variant changes only the visual theme, logo and copy. The Host Application's `LoginPage.js`, API client, validation, authentication, OTP/session handling and redirects remain unchanged.

## Available variants

| Config value | Design | Visual direction |
|---|---|---|
| `v1` | WhatsApp CRM | Original dark split-screen design with WhatsApp green accents |
| `v2` | News portal | Same split-screen layout, newsroom/editorial navy theme and coral accents |
| `v3` | Islamic education | Same split-screen layout, deep emerald theme, subtle geometric texture and antique-gold accents |
| `v4` | Minimal centered | Centered form card, supplied white logo on a dark logo plate, no marketing panel or social/register section |

## Select a design

In the host application's published `config/admin-ui.php`:

```php
'auth' => [
    'login' => 'v2', // v1, v2, v3 or v4
],
```

The package GET route continues to use `auth.route.path` and `auth.route.name`. The package owns only the GET Login page route. The host application owns the POST login endpoint.

## Variant-specific copy and branding

Variant defaults live under `auth.variants` in the package config. The service provider deep-merges these defaults into the host config at runtime, including when the host published an older `admin-ui.php`. The selected variant's `branding` and `login_page` values override the shared `auth.branding` and `auth.login_page` defaults. Host applications can customize the published config without changing the package Blade/CSS.

Example:

```php
'auth' => [
    'login' => 'v3',
    'variants' => [
        'v3' => [
            'branding' => [
                'logo_on_dark' => 'https://example.com/logo-white.webp',
                'logo_on_light' => 'https://example.com/logo-dark.webp',
                'logo_alt' => 'My Learning Portal',
            ],
            'login_page' => [
                'welcome_title' => 'Assalamu Alaikum',
                'welcome_description' => 'Continue your learning journey.',
                'submit_label' => 'Sign In',
            ],
        ],
    ],
],
```

A variant's `login_page.features` list replaces the shared feature list. `show_social_logins` and `show_register_link` can be set to `false` for a minimal layout.

## Asset URLs

The default V2 branding uses `https://newsnetworksindia.com/assets/newsLogo.webp` for both logo placements. Its left-panel background uses `https://bot.kotfumes.com/assets/images/background.webp`.

The default V3 branding uses the KotBot white and black logo URLs supplied for this design. V4 uses the KotBot white logo (`kotbot2.webp`) and places it on a dark logo plate so it remains legible.

These images are referenced by URL; they are not copied into the package. For production, host applications may download the images into their own public asset directory and replace the URLs in config.

## Demo routes

The demo application exposes:

- `/admin-ui/auth` — Login preview index
- `/admin-ui/auth/login-v1` — WhatsApp CRM
- `/admin-ui/auth/login-v2` — News portal
- `/admin-ui/auth/login-v3` — Islamic education
- `/admin-ui/auth/login-v4` — Minimal centered

Demo forms are marked as preview-only. Submitting a demo form shows a toast and never sends the entered credentials. Demo routes are in the sample host application, not registered by the reusable package.

## Stable form contract

All variants preserve these IDs and data hooks:

- `#loginForm`
- `#emailAddress`
- `#password`
- `#btnLogin`
- `#signInWithGoogle`
- `[data-password-toggle]`
- `[data-password-input]`
- `[data-social-login]`

The root page marker `data-admin-ui-page="auth-login-v1"` is intentionally kept stable for the already-published Host `LoginPage.js`. Do not change these hooks when adding another visual variant.
