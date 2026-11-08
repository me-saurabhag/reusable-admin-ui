# Auth Login Responsive Fix

## Changes

- Tablet and mobile login pages now use natural document height and vertical page scrolling.
- Login cards no longer have a viewport-bound max-height or hidden overflow at tablet/mobile breakpoints.
- The card remains vertically centered when there is sufficient viewport space, while longer content can scroll without being clipped.
- Login V4 now uses the dark KotBot logo (`kotbot1.webp`) on the light background. Its dark logo plate, padding, and shadow have been removed.
- Login form markup, IDs, data attributes, routes, and Host Application JavaScript hooks are unchanged.

## Files changed

- `resources/css/auth/login-v1.css`
- `config/admin-ui.php` (V4 `logo_on_light`)
