# Core Page Utilities — Package Integration

## Included files

- `resources/js/core/BasePage.js`
- `resources/js/core/LocationManager.js`

## Publishing

The service provider publishes both files using the `admin-ui-core` tag into the Host application's `resources/js/vendor/admin-ui/core/` directory. The Host Vite application compiles them through normal ES-module imports; the package does not add an NPM build pipeline.

## BasePage responsibilities

- Shared page root and DOM query helpers (`setRoot`, `query`, `queryAll`).
- Event listener registration tied to an `AbortController` lifecycle (`on`, `destroy`).
- Header and profile action event hooks.
- Optional Host Toast and Loader injection; no Host-specific imports are required by the package.
- Access to the shared LocationManager.

## LocationManager responsibilities

- One shared singleton per loaded module.
- Explicit geolocation requests only; no automatic permission prompt during page initialization.
- Concurrent request de-duplication and successful-result caching.
- Normalized error codes and accuracy helpers.
- `clear()` invalidates cached state and ignores callbacks from an older in-flight request. It cannot forcibly close a browser permission prompt.

## Host integration

Existing Host page imports now point to the published core module. Legacy `resources/js/pages/BasePage.js` and `LocationManager.js` files remain as small re-export shims for older imports. The Host's `UIManager` is exposed as `window.AdminUiToast` before page instances are created, keeping the package independent from Host-specific Toast implementations.

## Security and lifecycle notes

Browser geolocation requires HTTPS except on localhost. Browser-reported location is not authoritative evidence for AEPS geofencing or other security-sensitive authorization. Host pages should call `destroy()` when their page instance is replaced or disposed.
