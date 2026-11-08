# v0.2.1 — Spacing, Stack and Component Variants

## Component variants showcase page

A ready-made Blade view is included at:

`resources/views/pages/component-variants.blade.php`

Register a local development route in the host application's `routes/web.php`:

```php
use Illuminate\Support\Facades\Route;

Route::view('/admin-ui/components', 'admin-ui::pages.component-variants')
    ->name('admin-ui.components');
```

Open `/admin-ui/components` while developing. The page is intended as a visual test/reference page; remove or protect the route before production if it should not be publicly accessible. It uses the host application's normal layout assets and does not register a public route automatically.

## Margin properties

The unified components accept these optional spacing properties:

```blade
<x-admin-ui::button variant="primary" mt="3" mb="4">Save</x-admin-ui::button>
<x-admin-ui::badge variant="success" mx="auto">Active</x-admin-ui::badge>
<x-admin-ui::heading level="2" my="4">Customer details</x-admin-ui::heading>
```

Supported properties: `m`, `mt`, `mb`, `ms`, `me`, `mx`, `my`.

Allowed spacing values: `0`, `1`, `2`, `3`, `4`, `5`, `6`, `8`, `10`, `12`, `16`. Values map to the 4px spacing scale (for example, `3` = 12px). `auto` is supported for `mx`, `ms`, and `me` only. Invalid values throw an `InvalidArgumentException`.

For input/select, spacing applies to the outer field wrapper.

## Stack

Use Stack to create consistent vertical groups without manually adding margins:

```blade
<x-admin-ui::stack gap="3">
    <x-admin-ui::heading level="3">Customer details</x-admin-ui::heading>
    <x-admin-ui::input name="name" label="Customer name" />
    <x-admin-ui::button variant="primary">Save</x-admin-ui::button>
</x-admin-ui::stack>
```

`gap` uses the same spacing scale. `align` supports `start`, `center`, `end`, `stretch`; `as` supports `div`, `section`, `nav`, and `aside`.

## Changing colors with CSS variables

Create or update a host-app stylesheet loaded **after** the package stylesheet (for example `resources/css/custom-theme.css`), then override tokens:

```css
:root {
    --rai-primary: #2563eb;
    --rai-primary-hover: #1d4ed8;
    --rai-primary-active: #1e40af;
    --rai-primary-soft: #eff6ff;
    --rai-primary-contrast: #ffffff;

    --rai-secondary: #475569;
    --rai-secondary-soft: #f1f5f9;

    --rai-success: #15803d;
    --rai-success-soft: #f0fdf4;
    --rai-warning: #b45309;
    --rai-warning-soft: #fffbeb;
    --rai-danger: #dc2626;
    --rai-danger-soft: #fef2f2;
    --rai-info: #0284c7;
    --rai-info-soft: #f0f9ff;

    --rai-page-bg: #f8fafc;
    --rai-surface: #ffffff;
    --rai-surface-muted: #f1f5f9;
    --rai-heading: #0f172a;
    --rai-text: #1e293b;
    --rai-text-secondary: #475569;
    --rai-text-muted: #64748b;
    --rai-border: #e2e8f0;
    --rai-border-subtle: #f1f5f9;

    --rai-focus-ring: #2563eb;
    --rai-focus-ring-soft: rgb(37 99 235 / 14%);
}
```

Load the custom stylesheet after the framework stylesheet. If both are Vite entries, order them in the host layout so `admin-ui.css` loads first and `custom-theme.css` second. Prefer overriding tokens rather than targeting component selectors. Keep text/background contrast accessible.

## Update notes

- Adds margin utilities to the unified Button, Input, Select, Badge, Heading and Text components.
- Adds the Stack layout component.
- Adds the Component Variants showcase Blade view and styling.
- Existing component names and existing APIs remain available.
- No new NPM dependency is introduced.
