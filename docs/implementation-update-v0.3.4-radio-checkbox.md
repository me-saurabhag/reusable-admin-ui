# Implementation Update v0.3.4 — Radio & Checkbox

## Included
- Dedicated `radio-checkbox` showcase page.
- Checkbox examples: default, checked, disabled and inline layouts.
- Radio examples: vertical, horizontal, disabled and helper-text layouts.
- Switch examples: enabled, disabled and checked states.
- Scoped responsive showcase styles using existing `--rai-*` tokens.
- Improved checkbox old-input restoration for scalar and array field names (including `name="options[]"`).

## Host route

```php
Route::view('/admin-ui/radio-checkbox', 'admin-ui::pages.radio-checkbox')
    ->name('admin-ui.radio-checkbox');
```

## Apply
1. Back up the package.
2. Merge the package files from this update, preserving host-specific changes.
3. Add the route above to the host application's `routes/web.php`.
4. Run the host application's existing `npm run build` command.
5. Visit `/admin-ui/radio-checkbox` and test keyboard focus, selection, disabled states and mobile layout.

No new dependencies are introduced. Sidebar and Header are unchanged. Runtime testing must be performed in the host Laravel application.
