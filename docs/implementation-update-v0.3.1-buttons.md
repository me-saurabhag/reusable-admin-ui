# Implementation Update v0.3.1 — Buttons

This update focuses only on the Button component family and provides a dedicated Buttons showcase page.

## Reference direction
The page is informed by the button categories demonstrated in Mofi's Buttons page: flat/square, default semantic colors, sizes, outline, rounded/pill, disabled, icon buttons, button groups, and special emphasis styles. The implementation is original and uses the package's own `rai-` classes and `--rai-*` tokens.

Reference: https://admin.pixelstrap.net/mofi/template/buttons.html

## Dedicated showcase route

Add to host `routes/web.php`:

```php
Route::view('/admin-ui/buttons', 'admin-ui::pages.buttons')
    ->name('admin-ui.buttons');
```

Open `/admin-ui/buttons`. Keep the route inside your authenticated admin route group or remove it from production if it is only for component review.

## Button API

```blade
<x-admin-ui::button variant="primary">Save</x-admin-ui::button>

<x-admin-ui::button variant="success" appearance="soft" size="lg">
    Save Changes
</x-admin-ui::button>

<x-admin-ui::button variant="danger" appearance="outline" outline-width="bold">
    Delete
</x-admin-ui::button>

<x-admin-ui::button variant="primary" pill>Rounded</x-admin-ui::button>
<x-admin-ui::button variant="primary" square aria-label="Add item">+</x-admin-ui::button>
<x-admin-ui::button variant="primary" block>Full width</x-admin-ui::button>
```

### Properties

- `variant`: primary, secondary, success, info, warning, danger, dark, light. Legacy `outline` and `ghost` remain accepted.
- `appearance`: solid (default), outline, soft, ghost, link, gradient.
- `size`: xs, sm, md (default), lg.
- `pill`: fully rounded pill shape.
- `rounded`: existing rounded shape property retained.
- `square`: square icon-button shape.
- `outline-width`: normal (default) or bold.
- `block`: full-width button.
- `loading`, `disabled`, `type`.
- Existing margin props remain available.

### Leading and trailing content

Use named slots to supply your own icon component or inline icon markup:

```blade
<x-admin-ui::button variant="primary">
    <x-slot:leading>
        <x-admin-ui::icon name="plus" />
    </x-slot:leading>
    Add New
</x-admin-ui::button>

<x-admin-ui::button variant="success">
    Continue
    <x-slot:trailing>
        <x-admin-ui::icon name="arrow-right" />
    </x-slot:trailing>
</x-admin-ui::button>
```

Use an accessible `aria-label` for icon-only buttons.

## Compatibility
- The existing `<x-admin-ui::button>` name is unchanged.
- Existing `variant`, `appearance`, `size`, `disabled`, `loading` and spacing properties remain.
- This update does not modify Input, Select, Textarea, Badge, Sidebar or Header components.
- No new npm dependency is introduced.
