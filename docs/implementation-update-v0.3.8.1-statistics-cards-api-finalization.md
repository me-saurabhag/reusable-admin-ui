# v0.3.8.1 — Statistics Cards API Finalization

## Final API decisions
- `title`, `value`, `trend`, `trendLabel`, `badge`, split values, and `href` are passed by the host application.
- No business data is hardcoded in the component.
- The `icon` prop is an optional text/glyph fallback.
- The `iconSlot` is now supported consistently by all variants that display a primary icon: `split`, `revenue`, `icon-block`, and `watermark`.
- `accent-action` supports a dedicated `actionIconSlot`.
- `watermark` supports a dedicated `watermarkIconSlot` for the large decorative icon.
- All text/data props are escaped by Blade. Custom icon slots accept host-provided Blade/SVG/icon components.
- `href` makes the card render as an anchor; otherwise it renders as an article.
- Optional `footer` slot and custom HTML attributes remain supported.

## Usage
```blade
<x-admin-ui::stat-card
    variant="revenue"
    title="Total Revenue"
    :value="$dashboard['revenue']"
    :trend="$dashboard['revenue_trend']"
    trend-label="from last month"
>
    <x-slot:iconSlot>
        <img src="/assets/icons/revenue.svg" alt="">
    </x-slot:iconSlot>
</x-admin-ui::stat-card>
```

## Apply
1. Back up the package.
2. Merge the package from this archive.
3. Add/retain the showcase route:
```php
Route::view('/admin-ui/statistics-cards', 'admin-ui::pages.statistics-cards')
    ->name('admin-ui.statistics-cards');
```
4. Confirm the host Vite CSS entry imports the package CSS.
5. Run `npm run build` and test `/admin-ui/statistics-cards`.

No new NPM dependencies. Sidebar and Header are unchanged. Runtime testing remains to be performed in the host Laravel application.
