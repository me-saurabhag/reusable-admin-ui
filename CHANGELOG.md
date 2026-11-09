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
