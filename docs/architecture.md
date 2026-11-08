# Phase 1 architecture notes

## Responsibilities

- `AdminUiServiceProvider`: merges package config, registers namespaced Blade views/components, publishes config/assets, and validates preset names.
- `config/admin-ui.php`: package defaults and host-overridable asset paths.
- `resources/views/components`: anonymous Blade components registered under the `admin-ui` namespace.
- `resources/css/admin-ui.css`: shared `--rai-*` tokens and `rai-`-prefixed component/layout styles.
- `resources/js/admin-ui.js`: dependency-free, delegated interactions with explicit `init` and `dispose` methods.
- Host `public/vendor/bootstrap`: local Bootstrap distribution owned by the host, not by the package.

## Public naming

- Blade tag namespace: `x-admin-ui::...`
- CSS class/token namespace: `rai-` / `--rai-`
- JavaScript data attributes: `data-rai-*`
- JavaScript public API: `window.AdminUi`

## Asset policy

The package source files are published with the `admin-ui-assets` tag. The optional package layout links to configured host-public asset paths. A host that already loads Bootstrap can set `admin-ui.assets.include_bootstrap` to `false` to prevent duplicate assets.

## Testing

The primary integration tests live in the host Laravel application's `tests/Feature/AdminUiPackageTest.php`. Run them after Composer has installed the path package and Laravel has discovered the service provider.
