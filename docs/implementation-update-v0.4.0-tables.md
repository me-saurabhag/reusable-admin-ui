# Implementation Update v0.4.0 — Reusable Tables

## Added components

- `x-admin-ui::table`: content-first table container with heading, description, actions, header, body and footer slots.
- `x-admin-ui::table-head`: optional reusable `<thead>` wrapper.
- `x-admin-ui::table-row`: reusable `<tr>` wrapper.
- `x-admin-ui::table-cell`: optional `<td>` / `<th>` wrapper with alignment and width options.
- `x-admin-ui::table-toolbar`: standalone toolbar for use outside the table container.
- `x-admin-ui::table-empty-state`: empty-state row with configurable `colspan`.
- `x-admin-ui::pagination`: lightweight pagination UI for Laravel length-aware paginator instances.

## Table API

```blade
<x-admin-ui::table
    appearance="default"
    size="md"
    :hoverable="true"
    :striped="false"
    :responsive="true"
>
    <x-slot:heading>Contacts</x-slot:heading>
    <x-slot:description>Manage saved contacts.</x-slot:description>
    <x-slot:actions>
        <x-admin-ui::button size="sm">Add contact</x-admin-ui::button>
    </x-slot:actions>
    <x-slot:header>
        <tr><th>Name</th><th>Phone</th><th>Status</th></tr>
    </x-slot:header>

    @foreach ($contacts as $contact)
        <tr>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->phone }}</td>
            <td>{{ $contact->status }}</td>
        </tr>
    @endforeach
</x-admin-ui::table>

<x-admin-ui::pagination :paginator="$contacts" />
```

### Table props

- `appearance`: `default` (default), `bordered`, `minimal`.
- `size`: `sm`, `md` (default), `lg`.
- `hoverable`: boolean, defaults to `true`.
- `striped`: boolean, defaults to `false`.
- `responsive`: boolean, defaults to `true`; wraps the table in horizontal overflow handling.
- `flush`: boolean, removes outer card framing.
- Slots: `heading`, `description`, `actions`, `header`, default slot for rows, `caption`, `footer`.

### Pagination props

- `paginator`: Laravel length-aware paginator instance (required).
- `showSummary`: boolean, defaults to `true`.
- `maxPages`: number of nearby page links, defaults to `5`.

The host application must use `paginate()` / a length-aware paginator for the supplied pagination component. For `simplePaginate()` or cursor pagination, use host-owned navigation markup or extend the component deliberately.

## Responsibility boundary

The package renders HTML and styling only. The host application owns queries, authorization, filters, sorting, pagination state, actions and model-specific cell content. No DataTables dependency or client-side dataset engine was added. Table body rows are intentionally authored by the host so every module can have its own columns and nested components.

## Showcase

Added `resources/views/pages/tables.blade.php`, using the package layout so the host Vite entries load correctly. Register a host route to render `admin-ui::pages.tables` using the same route convention as the existing component showcases.

## Files

- Added seven Blade components under `resources/views/components/`.
- Added `resources/views/pages/tables.blade.php`.
- Appended table styles to `resources/css/admin-ui.css`.
- Added this update note and the corresponding docs page.

## Apply and test

1. Back up the current `reusable-admin-ui` directory.
2. Merge the ZIP's `reusable-admin-ui/` contents into the existing package directory; replace files when prompted. Do not replace the host application.
3. Publish the package assets with `php artisan vendor:publish --tag=admin-ui-assets`, then import the published stylesheet from `resources/css/vendor/admin-ui/admin-ui.css` in the host Vite entry.
4. Run `npm run build` from the host `admin-ui` application directory.
5. Register/open the Tables showcase route and test the three table appearances, mobile horizontal scrolling, and empty state.
6. In a host page, pass a Laravel `paginate()` result to `<x-admin-ui::pagination :paginator="$contacts" />` and verify page links preserve the current query string.

No database migrations or new JavaScript dependencies are required.
