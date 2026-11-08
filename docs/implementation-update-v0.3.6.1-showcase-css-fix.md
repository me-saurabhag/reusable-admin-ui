# v0.3.6.1 — Showcase CSS/Layout Fix

## Why this patch
The v0.3.6 showcase routes return their page views directly. The two showcase views did not include the package layout, while that layout loads the host Vite entries (`resources/css/app.css` and `resources/js/app.js`). Consequently, these direct routes could render as unstyled browser-default HTML even though the component CSS was present in `resources/css/admin-ui.css`.

## Fix
- Wrap the Dropdowns showcase in `<x-admin-ui::layout title="Dropdowns">`.
- Wrap the Accordion showcase in `<x-admin-ui::layout title="Accordion">`.
- This loads the host Vite assets on both standalone showcase routes.
- No component styles or Sidebar/Header implementation were changed.

## Apply
1. Back up the package.
2. Merge the two updated Blade views from this archive.
3. Publish the package assets with `php artisan vendor:publish --tag=admin-ui-assets`, then confirm the host Vite entry imports the published files from `resources/css/vendor/admin-ui/` and `resources/js/vendor/admin-ui/`.
4. Run `npm run build` in the host application.
5. Hard-refresh `/admin-ui/dropdowns` and `/admin-ui/accordions`.

If the host application deliberately renders these pages inside a different application layout, use that layout instead and ensure it loads the same Vite entries.
