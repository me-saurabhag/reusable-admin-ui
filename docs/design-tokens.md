# Design Tokens and Host Theme Overrides

The framework uses CSS custom properties (design tokens) so each Host
Application can apply its own brand colors, typography, spacing and surfaces
without editing files published by the package.

The source token files live under `resources/css/tokens/` and are combined by
`resources/css/admin-ui.css`.

| File | Responsibility |
|---|---|
| `colors.css` | Primary/secondary brand colors, semantic colors, surfaces, text, borders, focus ring and sidebar |
| `typography.css` | Font family, type scale, weights and line heights |
| `spacing.css` | 4px-based spacing scale |
| `dimensions.css` | Control, card, table, dialog, offcanvas and shell dimensions |
| `radius.css` | Border widths and corner radius scale |
| `shadows.css` | Elevation and transition tokens |

## Where to add overrides

The installer imports the package global stylesheet through
`resources/css/app.css`. Keep your application-specific overrides in the
Host Application, not in `resources/css/vendor/admin-ui/` (that folder is
package-managed and can be refreshed during an update).

Add your overrides at the **bottom of `resources/css/app.css`**, after the
Tailwind directives and the package imports. This ensures your values take
precedence over the package defaults.

## Change the primary brand color

For example, to change the default green brand to blue:

```css
:root {
    --rai-primary: #2457a6;
    --rai-primary-hover: #1d4788;
    --rai-primary-active: #17396d;
    --rai-primary-soft: #eaf0fb;
    --rai-primary-contrast: #ffffff;

    --rai-focus-ring: #2457a6;
    --rai-focus-ring-soft: rgb(36 87 166 / 14%);
}
```

Set the related hover, active, soft and contrast values together so buttons,
active navigation states and other branded components remain visually
consistent.

## Other color tokens

You can override any of the supported color variables. Common examples:

```css
:root {
    /* Secondary brand */
    --rai-secondary: #287f78;
    --rai-secondary-soft: #e8f3f2;

    /* Semantic states */
    --rai-success: #16834a;
    --rai-success-soft: #eaf5ee;
    --rai-warning: #b7791f;
    --rai-warning-soft: #fff6e5;
    --rai-danger: #c43d4b;
    --rai-danger-soft: #fcebed;
    --rai-info: #2877a8;
    --rai-info-soft: #eaf4fa;

    /* Page and component surfaces */
    --rai-page-bg: #f6f8fa;
    --rai-surface: #ffffff;
    --rai-surface-muted: #f7f9fb;
    --rai-surface-elevated: #ffffff;

    /* Text and borders */
    --rai-heading: #17212b;
    --rai-text: #273444;
    --rai-text-secondary: #536174;
    --rai-text-muted: #718096;
    --rai-border: #e2e8ef;
    --rai-border-subtle: #edf1f5;
    --rai-divider: #e9eef3;

    /* Sidebar */
    --rai-sidebar-bg: #17212b;
    --rai-sidebar-text: #cbd5df;
    --rai-sidebar-muted: #8d9aa7;
    --rai-sidebar-active-bg: rgb(22 131 74 / 22%);
}
```

Only override the values that your brand needs. The examples above show the
default palette; replace them with your own colors.

## Typography and spacing

Typography and spacing use the same Host override approach:

```css
:root {
    --rai-font-family: "Inter", sans-serif;
    --rai-font-size-body: 14px;
    --rai-font-weight-semibold: 600;
    --rai-line-height-body: 1.5;

    --rai-space-1: 4px;
    --rai-space-2: 8px;
    --rai-space-3: 12px;
    --rai-space-4: 16px;
    --rai-space-6: 24px;
}
```

See the source files under `resources/css/tokens/` for the complete token
names and defaults. Components that consume a token will reflect the Host
override automatically. A component with a deliberately fixed or
variant-specific style may require its own page/component override.

## Scope: Admin UI versus Authentication pages

The `--rai-*` tokens are the shared design system for Admin UI components
and layouts. Authentication pages have their own visual styling and may use
page-scoped variables in addition to the shared tokens.

For example, Login V1 uses the `--wa-green` family for its accent color. To
change that page's accent without editing package files, add an override to
the Host Login CSS entry wrapper
(`resources/css/pages/auth/login.css`) **after** its package imports:

```css
@import '../../vendor/admin-ui/auth/login-v1.css';
@import '../../vendor/admin-ui/otp-dialog.css';
@import '../../vendor/admin-ui/status-dialog.css';

/* Host-owned Login V1 brand override */
.rai-auth-login-v1 {
    --wa-green: #2457a6;
    --wa-green-dark: #1d4788;
    --wa-green-darker: #17396d;
}
```

Keep this override in the Host-owned wrapper, not in
`resources/css/vendor/admin-ui/auth/login-v1.css`. If a different Login
variant is selected, inspect that variant's scoped selectors before adding
its override.

## Important rules

- Do not edit files inside `resources/css/vendor/admin-ui/`; the installer
  may refresh those package-managed copies.
- Put brand overrides in Host-owned `resources/css/app.css` or the relevant
  Host page CSS entry.
- Prefer overriding existing `--rai-*` tokens over writing broad selectors
  against Bootstrap classes.
- Overrides affect only components that use the corresponding token. They
  do not automatically recolor every Bootstrap utility or every
  authentication-page-specific style.
- Keep the `rai-` prefix. It is the framework's compatibility namespace.
