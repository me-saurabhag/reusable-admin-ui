# Sidebar component contract (Phase 1)

## Default behaviour

- Desktop initial state is collapsed (`80px`). Expanded width is `250px`.
- State is not persisted. Every page load starts collapsed on desktop.
- Below `992px`, the sidebar is an off-canvas drawer with a backdrop.
- The drawer closes from the backdrop, Escape, or selecting a navigation link.
- Only one submenu can be open at a time.
- Clicking a submenu parent toggles its children; children perform navigation.
- A child matching the current Laravel route causes its parent group to render expanded.
- CSS and JavaScript are namespaced to `.rai-ui` and `data-rai-*` hooks.

## Host-provided brand slot

```blade
<x-admin-ui::sidebar :sections="config('admin-ui.sidebar.sections')">
    <x-slot:brand>
        <a class="rai-ui__sidebar-brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/admin-logo.svg') }}" alt="Acme Admin" height="36">
            <span class="rai-ui__brand-name">Acme Admin</span>
        </a>
    </x-slot:brand>
</x-admin-ui::sidebar>
```

The slot is rendered by the host application. Ensure the logo remains identifiable in the compact width; the framework does not modify the supplied asset.

## PHP menu configuration

Define menu sections in the host application's Blade view (or prepare them in its controller) and pass `:sections="$sections"` to the Blade component. The package default is an empty menu.

```php
'sidebar' => [
    'default_collapsed' => true,
    'persist_state' => false,
    'mobile_breakpoint' => 992,
    'sections' => [
        [
            'label' => 'Workspace',
            'items' => [
                ['label' => 'Overview', 'icon' => 'stroke-layout', 'route' => 'admin.dashboard'],
                [
                    'label' => 'Customers',
                    'icon' => 'stroke-user',
                    'children' => [
                        ['label' => 'All Customers', 'route' => 'admin.customers.index'],
                        ['label' => 'Groups', 'url' => '/admin/customer-groups'],
                    ],
                ],
            ],
        ],
    ],
],
```

Supported item fields:

- `label` (string): visible menu label.
- `icon` (string): ID of a `<symbol>` in the inline SVG sprite, for example `stroke-layout`.
- `route` (string): named Laravel route; route matching supports the route name and its `.*` descendants.
- `url` (string): direct URL. If supplied, it takes precedence over `route`.
- `active` (bool): explicitly marks an item active when route inference is insufficient.
- `tooltip` (string): optional tooltip for a leaf item; label is the fallback tooltip.
- `children` (array): nested child links. The current UI supports one submenu level.
- section `label` / `section` (string) and `items` (array).

The sprite is included once by the package layout from `resources/views/components/icon-sprite.blade.php`. Add new symbols there and use their IDs in the menu array.

A missing/unregistered route falls back to `#` to avoid throwing while rendering a demo. Configure real route names in the host application. The UI's visibility settings are not authorization: enforce access control in Laravel middleware, policies, gates, and controllers.

## Manual verification checklist

- Desktop starts at 80px and toggles between 80px and 250px.
- Reload resets desktop state to collapsed.
- At widths below 992px, the sidebar starts closed and opens as an overlay drawer.
- Backdrop click, Escape, and link selection close the mobile drawer.
- Clicking a submenu parent opens it and closes any previously open submenu.
- Current child route marks the child active and opens its parent.
- Keyboard focus is visible and icon-only navigation has accessible names/tooltips.
- Package styles do not affect unscoped host elements.


### SVG sprite icons

Menu `icon` values are IDs from the inline SVG sprite at `resources/views/components/icon-sprite.blade.php`. Use IDs such as `stroke-layout`, `stroke-user`, `stroke-chat`, or `stroke-file`. The sprite is included once by the package layout; no per-icon assets are published.
