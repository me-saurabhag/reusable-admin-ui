# v0.3.7 — Lists

- Reusable `list` and `list-item` Blade components.
- Ordered/unordered lists; bullet and number markers.
- Default, bordered, divided and flush appearances.
- Small, medium and large density; none/small/medium/large gaps.
- Named `leading` and `trailing` slots, plus title, description and meta props.
- Dedicated Lists showcase: basic, bordered, divided, icon/action, activity and contact list patterns.

Route:
```php
Route::view('/admin-ui/lists', 'admin-ui::pages.lists')->name('admin-ui.lists');
```

Apply: back up the package, merge this archive, confirm the host Vite CSS entry imports the package `resources/css/admin-ui.css`, run `npm run build`, then visit `/admin-ui/lists`.

No new NPM dependencies. Sidebar and Header are unchanged. Test the showcase in the host Laravel runtime.
