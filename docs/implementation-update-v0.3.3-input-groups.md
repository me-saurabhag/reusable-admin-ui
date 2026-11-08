# Reusable Laravel Admin UI — Update v0.3.3 (Input Groups)

This update introduces a reusable Input Group component and its dedicated showcase page. It supports prepend/append content, action buttons, multiple controls and consistent sizing.

## Component API

```blade
<label class="rai-field__label" for="account-handle">Username</label>
<x-admin-ui::input-group>
    <x-slot:prepend>@</x-slot:prepend>
    <input id="account-handle" class="rai-control rai-control--outline" name="username" type="text" placeholder="username">
</x-admin-ui::input-group>
```

- `prepend` and `append` are optional named slots and may contain text, icons or buttons.
- The default slot contains the actual native input/select/textarea controls. Use the existing `rai-control` classes to keep their appearance consistent.
- `size` accepts `sm`, `md` or `lg` and defaults to `md`.
- `full-width` defaults to `true`.
- Keep the `<label>` outside the group and associate it with the relevant control using `for` and `id`.
- Each control in a multi-control group should have its own accessible name (visible label or `aria-label`).

## Apply
1. Back up your current `reusable-admin-ui/` package directory.
2. Extract the archive and merge the included `reusable-admin-ui/` directory into your package directory. Preserve local customizations and review conflicts rather than blindly overwriting them.
3. Add the route below to the host application's `routes/web.php`:

```php
Route::view('/admin-ui/input-groups', 'admin-ui::pages.input-groups')
    ->name('admin-ui.input-groups');
```

4. Confirm the package CSS is included by the host app, then run the host app's existing `npm run build`.
5. Open `/admin-ui/input-groups` and test responsive behavior and keyboard focus on grouped controls.

## Files added
- `resources/views/components/input-group.blade.php`
- `resources/views/pages/input-groups.blade.php`
- `docs/implementation-update-v0.3.3-input-groups.md`

## Files updated
- `resources/css/admin-ui.css`

No new NPM dependencies. Sidebar and Header are unchanged. Runtime testing in the user's Laravel application has not been performed.
