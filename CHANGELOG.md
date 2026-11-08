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
