# Release checklist

1. Review package changes and update `CHANGELOG.md`.
2. Run `composer validate --strict` from the package root.
3. Run PHP syntax checks for `src/`, `config/`, and Blade PHP files.
4. Run JavaScript syntax checks for `resources/js/` and `resources/stubs/`.
5. Verify Login, Registration, and Forgot Password styles, scripts, Status Dialog, and OTP Dialog in the local `admin-ui-fresh-test` host using a Composer path repository.
6. Verify the authenticated shared layout does not automatically include either dialog or its page-scoped stylesheet.
7. Test an upgrade with an already-published config containing legacy auth Vite paths, including the older Registration `LoginPage.js` value; confirm custom Vite overrides remain unchanged.
8. Run `admin-ui:install` twice, then run `admin-ui:install --force`; confirm Host config, auth page starters, wrappers, `vite.config.js`, and `resources/js/app.js` are not overwritten.
9. Install the package from GitHub in a separate fresh Laravel application and verify publishing, Vite production build, and the three authentication pages.
10. Confirm the GitHub Actions `Package CI` workflow passes.
11. Create and push a version tag only after both host-application tests pass.
12. Create the corresponding GitHub Release and verify the Composer installation instructions.

The package CI workflow checks package-owned source, configuration, and JavaScript syntax. Full browser/UI integration checks belong to the host applications used for package testing.
