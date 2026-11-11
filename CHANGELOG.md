## Unreleased - Unified external SVG sprite across layouts

- Update the shared Icon component to reference symbols from the published external SVG sprite file.
- Use the same configurable sprite URL in authentication pages, post-login components, and sidebar navigation.
- Remove the authentication layout's inline SVG sprite markup so both layouts share the cached public asset.
- Add `assets.icon_sprite` as the Host-configurable public path, defaulting to `vendor/admin-ui/icons.svg`.

## Unreleased - Reduced Admin page content padding

- Reduce the shared Admin content area's default padding on desktop and mobile for a more space-efficient page layout.
- Keep component-internal spacing, including the Dashboard Hero section, unchanged.

## Unreleased - Configurable Header profile menu routes and methods

- Allow each profile menu item to target a Host Application named route.
- Render GET destinations as links and POST, PUT, PATCH, or DELETE destinations as CSRF-protected forms with Laravel method spoofing where required.
- Preserve the existing `admin-ui:profile-action` button event when a route is not configured or is unavailable.
- Document profile menu route and method configuration for Host Applications.

## Unreleased - SVG icon compatibility and WhatsApp navigation icons

- Add missing stroke-style symbols used by the Host Application's WhatsApp admin menu, including monitor, add, reply, list, users, megaphone, history, conversation, inbox, automation, key, repeat, file, folder, status, clock, code, gauge, book, and logout icons.
- Restore the `refresh`, `send`, and `automation` symbol IDs retained by existing package consumers.
- Add correctly spelled aliases for commonly mistyped icon IDs such as `attachment`, `dollar-return`, and `map-location` while preserving the legacy IDs for compatibility.

## Unreleased - Post-Login Base Layout

- Add `admin-ui::layouts.app` as the shared authenticated Admin layout, composing the package layout, Header, and Sidebar.
- Keep page content and page-specific CSS/JavaScript owned by each Host Application page.
- Accept the permission-filtered Sidebar menu from the Host Application's `AdminMenuProvider` through `AdminLayoutComposer`; the package does not perform authorization checks.
- Support optional Host-provided `headerData` for profile details and header information cards.
- Document layout extension, Vite page entries, and Host view-composer registration.

## Unreleased - Modular Admin page layout and external SVG sprite

- Keep the shared Admin layout focused on the shell, header/sidebar slots, shared Vite entries, and page asset stacks.
- Add a dedicated `admin-ui:styles` stack and retain `admin-ui:head` for page-level head assets; load `admin-ui:scripts` after shared runtime assets.
- Remove automatic Status Dialog inclusion and remove the inline SVG sprite from the shared layout.
- Publish the SVG symbol sprite as `public/vendor/admin-ui/icons.svg` and update sidebar icons to reference external symbols.
- Keep OTP and Status Dialog markup/styles opt-in at page level.

## Unreleased - Simplified Forgot Password form ownership

- Keep the Forgot Password starter limited to preparing the form, attaching shared form helpers, and password visibility toggles.
- Remove OtpManager initialization and the form.otpDialog property; the Host Application uses the separate OTP helper directly.
- Keep native form submission handling entirely in the Host Application, which reads values with form.getFormValues().
- Do not dispatch a custom submit event or make API calls from the package.
- Leave Login and Registration files and behavior unchanged.

## Unreleased - Host-controlled authentication form submission

- Add reusable form helpers to BasePage: getFormValues, getFormData, getFieldValue, setFieldValue, clearForm, and setFormLoading.
- Expose these helpers directly on the Forgot Password form element for Host Application use.
- Keep form submission, API requests, server validation, OTP workflow, and response handling entirely under Host Application control.
- Switch the Forgot Password primary action to a native submit button so browser validation runs before the submit event.
- Leave Login and Registration starter behavior and views unchanged.

## Unreleased - Configurable shared favicon

- Add a top-level `favicon` configuration value with the requested chatbot image as its default.
- Render the configured favicon in both the shared Admin layout and authentication layout; allow it to be disabled with a null or empty value.
- Document the Host Application override.

## Unreleased - Configurable registration country selector and request payload

- Add a configurable registration country list with India selected by default.
- Render calling code and country region from configuration instead of hardcoded options.
- Include the normalized registration request object in the `admin-ui:register-submit` event while preserving FormData and OTP integration.
- Document country configuration and the Host event payload.

## Unreleased - Guest-only authentication page routes

- Apply configurable guest middleware to the package-owned Login, Registration, and Forgot Password GET routes.
- Preserve each route's existing middleware and allow the host application to supply a custom middleware class/name or disable the additional guest middleware.
- Document authenticated-user redirect destination ownership in the host Laravel application.

## Unreleased - Toast notification service and core publishing fix

- Add a lightweight Toast service with success, info, warning, error, dismiss, and clear APIs.
- Add scoped Toast styles and publish the JavaScript and CSS through the `admin-ui-core` tag.
- Import Toast as the safe BasePage fallback so `this.toast` is available to Login, Registration, Forgot Password, and other BasePage-derived pages without relying on an undeclared global.
- Document Toast methods and Vite CSS integration.

## Unreleased - Authentication click-based actions and OTP manager import

- Change Login, Registration and Forgot Password primary actions to `type="button"`.
- Handle each action through its button click listener and retain browser validation with `form.reportValidity()`.
- Dispatch Host-facing authentication events without falling back to native form submission.
- Explicitly import and initialize OtpManager in the authentication starter pages to prevent an undefined module reference.
- Include the OTP manager instance in each custom event detail when the OTP modal is present.
- Document the click-event and OTP integration contract.

## Unreleased - Shared frontend validation helpers

- Add the reusable Validation utility with email, mobile, password, PIN code, Aadhaar-format, UUID and numeric string helpers.
- Publish Validation.js through the existing admin-ui-core tag for direct use by Host Vite entry points.
- Document initialization and Login form usage.

## Unreleased - Location-aware page foundation

- Add optional `LocationAwarePage` extending the lightweight `BasePage`.
- Centralize fresh location requests, page-level location state, accuracy helpers, and retryable Location Status Dialog behavior.
- Publish `LocationAwarePage.js` through the `admin-ui-core` asset tag.
- Document page-load location requests and adding coordinates to FormData.

## Unreleased - Modular API client and authentication logo alignment

- Add reusable fetch-based API client, normalized response classes, API defaults and shared Loader under the core services.
- Keep BasePage lightweight; API, location and dialog services are no longer imported by every page through the base class.
- Publish the API service files through the existing admin-ui-core asset tag.
- Center the light-background brand logo consistently on Login, Registration and Forgot Password forms.
- Escape Loader title and message as text instead of interpolating them into HTML.

# Changelog

All notable changes to this project are documented here.

## Unreleased - Authentication JavaScript loading

- Load authentication CSS in the document head and the configured JavaScript entry point immediately before the closing body tag.
- Preserve configurable Vite CSS and JavaScript entry points for Login, Registration, and Forgot Password pages.

## Unreleased - Authentication Vite upgrade compatibility

- Normalize exact legacy Login, Registration, and Forgot Password Vite defaults from already-published host configs to the shared `app.css` and `app.js` entry points at runtime.
- Cover the earlier Registration config that pointed to `LoginPage.js` as well as the expected `RegisterPage.js` default.
- Preserve custom Vite entry points and avoid requiring `vendor:publish --force` for this compatibility update.

## 0.2.0 - Host Vite integration and installation fixes

- Align Login, Registration, and Forgot Password default Vite entry points with the host application's `resources/css/app.css` and `resources/js/app.js`.
- Make Forgot Password Vite entry points configurable, matching the other authentication pages.
- Default Bootstrap loading to disabled because Bootstrap is owned and loaded by the host application.
- Document the complete asset publishing and shared Vite integration workflow.
- Correct the package installation guidance for local and Git-based host applications.

## 0.1.0 - Initial public-ready baseline

- Reusable Laravel 13 Blade admin UI components and responsive admin shell.
- Configurable sidebar, header, authentication presentation, and SVG icon sprite.
- Dashboard hero, messaging activity chart, conversation/automation health, and statistic card variants.
- Reusable dialogs, OTP UI, pagination, PIN input, offcanvas, and location utilities.
