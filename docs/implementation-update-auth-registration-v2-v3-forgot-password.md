# Auth UI update — Registration V2/V3 and Forgot Password

## Included
- Registration V2 (News Portal) and V3 (Islamic Education) use the shared registration Blade view.
- The shared registration field order is Name, Email, Mobile/Country Code, Referral Code (Optional), Create Account.
- Country selector labels use short country identifiers: IN (+91), US (+1), UK (+44).
- Shared registration CSS includes legibility and small-screen refinements for V2 and V3.
- Forgot Password remains a centered page with Email, New Password and Re-Type Password; CSS now includes clearer password-toggle focus/hover states, validation styling and mobile/safe-area refinements.
- No Login, Sidebar or Header files were changed.

## Update कैसे करें

1. Extract this ZIP to a temporary folder.
2. In your Host Application, copy the following Package files from `workspace/reusable-admin-ui/` to the same paths in your existing `reusable-admin-ui/` package:
   - `resources/css/auth/register.css`
   - `resources/css/auth/forgot-password.css`
3. The Registration Blade and Forgot Password Blade are shared and already present in this release; replace them only if you are updating the complete package folder from this ZIP:
   - `resources/views/auth/register/v1.blade.php`
   - `resources/views/auth/forgot-password.blade.php`
4. In the Host Application directory, rebuild Vite assets:
   ```bash
   npm run build
   ```
   (The ZIP intentionally excludes `node_modules`; run the build where the Host Application's dependencies are installed.)
5. Clear Laravel's cached views/config:
   ```bash
   php artisan optimize:clear
   ```
6. Preview Registration V2 and V3 by setting `admin-ui.auth.registration.variant` to `v2` or `v3` in the Host config, then open the configured registration URL.
7. Open the configured `/forgot-password` route and verify email/password fields, show/hide controls, validation messages and mobile layout.

## Notes
- This is a UI package update only. It does not implement the Host Application's registration or password-reset API.
- The Forgot Password form's actual reset endpoint, token/OTP flow and server-side validation remain the Host Application's responsibility.
- No full Laravel/browser test was run in this environment.
