# Release checklist

Before publishing a GitHub release:

1. Confirm the package API and Blade component names in `README.md` and `docs/`.
2. Review `config/admin-ui.php` and replace sample branding, logo URLs, copy, and route settings for the consuming application.
3. Run `composer validate --strict` from the repository root.
4. Follow `demo/README.md` from a clean checkout.
5. Run `php artisan test` from `demo/` after publishing package files.
6. Run `npm run build` from `demo/`.
7. Review `git status` and confirm no `.env`, credentials, `vendor/`, `node_modules/`, `public/build/`, logs, sessions, or compiled cache files are staged.
8. Update `CHANGELOG.md`, commit, and push to `main`.
9. Create and push a version tag, for example `v0.1.0`, only after the release has been approved.

The CI workflow in `.github/workflows/ci.yml` runs Composer validation, publishes the package files into the demo, builds frontend assets, and runs the Laravel test suite.
