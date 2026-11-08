# v0.3.8 — Ready-made Statistics Cards

## Included
A single reusable `stat-card` Blade component with six ready-made variants:
- `split`
- `revenue`
- `accent-action`
- `icon-block`
- `compact`
- `watermark`

Supports title/value, icon and icon slots, trend labels, split metrics, badge, optional link, footer slot and optional height.

## Route
```php
Route::view('/admin-ui/statistics-cards', 'admin-ui::pages.statistics-cards')
    ->name('admin-ui.statistics-cards');
```

## Usage
```blade
<x-admin-ui::stat-card
    variant="revenue"
    title="Total Revenue"
    value="$48,290"
    trend="↑ 12.8%"
    trend-label="from last month"
    icon="$"
/>
```

## Apply
1. Back up the package and merge `reusable-admin-ui/` from this archive.
2. Confirm the host Vite CSS entry imports the package `resources/css/admin-ui.css`.
3. Add the route above to host `routes/web.php`.
4. Run `npm run build` in the host application.
5. Visit `/admin-ui/statistics-cards`.

No new NPM dependencies. Sidebar and Header are unchanged. Runtime testing must be performed in the host Laravel application.
