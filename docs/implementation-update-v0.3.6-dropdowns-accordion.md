# Implementation Update v0.3.6 — Dropdowns & Accordion

This update adds two independent component families and dedicated showcase pages.

## Dropdowns

- `x-admin-ui::dropdown` with `placement` (`bottom-start`, `bottom-end`, `top-start`, `top-end`) and `width` (`sm`, `md`, `lg`, `auto`).
- Provide the trigger using the named `trigger` slot and mark its button with `data-rai-dropdown-toggle`.
- `x-admin-ui::dropdown-item` supports links, buttons, disabled state, danger styling and dividers.
- Runtime supports outside-click dismissal, Escape, ArrowUp/ArrowDown and Home/End navigation, focus on first menu item, and closing after item selection.
- Trigger is click-based in this release.

Example:

```blade
<x-admin-ui::dropdown placement="bottom-end" width="md">
    <x-slot:trigger>
        <button type="button" class="rai-btn rai-btn--primary rai-btn--solid"
                data-rai-dropdown-toggle aria-expanded="false">
            Actions
        </button>
    </x-slot:trigger>

    <x-admin-ui::dropdown-item href="/profile">View profile</x-admin-ui::dropdown-item>
    <x-admin-ui::dropdown-item danger>Remove</x-admin-ui::dropdown-item>
</x-admin-ui::dropdown>
```

## Accordion

- `x-admin-ui::accordion` supports `mode="multiple|single"` and `appearance="default|bordered|separated|flush"`.
- `x-admin-ui::accordion-item` supports `title`, `open`, and `disabled`.
- Native buttons provide keyboard activation; panels use `aria-controls`, `aria-labelledby`, and `hidden` state.
- Emits bubbling `rai:accordion:toggle` from the item with `{ open: boolean }` detail.

Example:

```blade
<x-admin-ui::accordion mode="single" appearance="bordered">
    <x-admin-ui::accordion-item title="Account details" open>
        Account information goes here.
    </x-admin-ui::accordion-item>
    <x-admin-ui::accordion-item title="Security">
        Security information goes here.
    </x-admin-ui::accordion-item>
</x-admin-ui::accordion>
```

## Showcase routes

```php
Route::view('/admin-ui/dropdowns', 'admin-ui::pages.dropdowns')->name('admin-ui.dropdowns');
Route::view('/admin-ui/accordions', 'admin-ui::pages.accordions')->name('admin-ui.accordions');
```

Build assets using the host application's existing `npm run build` command. No new NPM dependencies are introduced. Sidebar and Header are unchanged.
