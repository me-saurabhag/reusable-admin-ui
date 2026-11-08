# Release checklist

1. Review the package changes and update `CHANGELOG.md`.
2. Run `composer validate --strict` from the package root.
3. Run PHP syntax checks for `src/` and `config/`.
4. Run JavaScript syntax checks for `resources/js/` and `resources/stubs/`.
5. Verify package installation and component rendering in the separate Laravel demo/host application.
6. Confirm the GitHub Actions `Package CI` workflow passes.
7. Create and push an annotated version tag (for example, `v0.1.1`).
8. Create the corresponding GitHub Release and verify the Composer installation instructions.

The package CI workflow intentionally checks only package-owned source, configuration, and JavaScript syntax. Full browser/UI integration checks belong to the separately maintained demo/host application.
