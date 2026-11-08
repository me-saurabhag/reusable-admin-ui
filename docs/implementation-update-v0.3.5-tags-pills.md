# Implementation Update v0.3.5 — Tags & Pills

## Included
- Added `x-admin-ui::tag` for category labels and removable selection tags.
- Added `x-admin-ui::pill` for rounded status and metadata indicators.
- Supported semantic variants: `primary`, `success`, `warning`, `danger`, `info`, `neutral`.
- Supported appearances: `soft`, `solid`, `outline` and sizes: `sm`, `md`, `lg`.
- Added optional `dot` to pills and `removable` to tags.
- Added the dedicated `tags-pills` showcase page and responsive styling.
- Added delegated remove behavior. Clicking a removable tag's × dispatches a bubbling `rai:tag:remove` CustomEvent with `{ tag, value }`, then removes the tag element. Host applications remain responsible for synchronizing form/application state.

## Showcase route

```php
Route::view('/admin-ui/tags-pills', 'admin-ui::pages.tags-pills')
    ->name('admin-ui.tags-pills');
```

## Examples

```blade
<x-admin-ui::tag variant="success">Verified</x-admin-ui::tag>
<x-admin-ui::tag variant="primary" appearance="outline" removable>Laravel</x-admin-ui::tag>
<x-admin-ui::pill variant="success" dot>Active</x-admin-ui::pill>
<x-admin-ui::pill variant="warning" appearance="solid" size="sm">Pending</x-admin-ui::pill>
```

## Apply
1. Back up the existing package.
2. Merge the `reusable-admin-ui/` directory from this archive, preserving local customizations.
3. Add the showcase route above to the host application's `routes/web.php`.
4. Run the host application's existing `npm run build` command.
5. Visit `/admin-ui/tags-pills` and test all variants, sizes, removable tags, and mobile layout.

No new NPM dependencies. Sidebar and Header are unchanged. Source-level checks and ZIP integrity are verified; Laravel runtime testing must be performed in the host application.
