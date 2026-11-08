# Implementation Update v0.3.0 — Component Visual Redesign

## Design direction

This release refines the component visual language using the general visual approach of modern Bootstrap admin themes (including Mofi) as inspiration. It is an independent implementation; no Mofi source code or CSS is copied.

## New and updated APIs

### Button

```blade
<x-admin-ui::button variant="primary" appearance="solid">Save</x-admin-ui::button>
<x-admin-ui::button variant="success" appearance="outline">Approve</x-admin-ui::button>
<x-admin-ui::button variant="danger" appearance="soft">Delete</x-admin-ui::button>
<x-admin-ui::button variant="primary" appearance="gradient" size="lg">Continue</x-admin-ui::button>
<x-admin-ui::button variant="primary" rounded>Rounded</x-admin-ui::button>
<x-admin-ui::button variant="primary" block>Full width</x-admin-ui::button>
```

- `variant`: primary, secondary, success, warning, danger, info, light, dark. Legacy `outline` and `ghost` values remain accepted.
- `appearance`: solid (default), outline, soft, ghost, link, gradient.
- `size`: sm, md, lg.
- `rounded`, `block`, `loading`, `disabled`.

### Form controls

Input and Select accept `appearance="outline|filled|underline"` (outline is default). Existing size, help, error, required and spacing properties remain.

```blade
<x-admin-ui::input name="email" label="Email" appearance="filled" placeholder="name@example.com" />
<x-admin-ui::select name="status" label="Status" appearance="outline">
    <option value="active">Active</option>
</x-admin-ui::select>
<x-admin-ui::textarea name="message" label="Message" rows="4" help="Add a short note." />
```

New components:
- `<x-admin-ui::textarea>`
- `<x-admin-ui::checkbox name="updates" label="Email updates" checked />`
- `<x-admin-ui::radio name="plan" value="pro" label="Professional" />`
- `<x-admin-ui::switch name="enabled" label="Enable automation" checked />`
- `<x-admin-ui::button-group>...</x-admin-ui::button-group>`

Checkbox, radio and switch are native form inputs with styled labels. They submit standard HTML form values and can be used with Laravel validation.

### Badges

```blade
<x-admin-ui::badge variant="success">Connected</x-admin-ui::badge>
<x-admin-ui::badge variant="danger" appearance="solid">Failed</x-admin-ui::badge>
<x-admin-ui::badge variant="warning" appearance="outline" dot>Pending</x-admin-ui::badge>
<x-admin-ui::badge variant="info" pill>In progress</x-admin-ui::badge>
```

- `variant`: primary, success, warning, danger, info, neutral.
- `appearance`: soft (default), solid, outline.
- `size`: sm, md; optional `pill` and `dot`.

## Component showcase

The existing view has been expanded and remains at:

`resources/views/pages/component-variants.blade.php`

Use the local route in `routes/web.php`:

```php
Route::view('/admin-ui/components', 'admin-ui::pages.component-variants')
    ->name('admin-ui.components');
```

Protect or remove the route before production if appropriate.

## CSS variables

The components use the existing `--rai-*` tokens for brand and semantic colors. Host applications should override tokens in a stylesheet loaded after the package stylesheet. No component-specific selector overrides should be needed for normal color theming.

## Compatibility

- Existing component names are retained.
- Button's older `variant="outline"` and `variant="ghost"` values remain accepted for compatibility.
- Existing `size`, `disabled`, `loading`, labels, validation errors and margin props are retained.
- Sidebar and Header files are not changed by this release.
- No NPM dependencies are added.
