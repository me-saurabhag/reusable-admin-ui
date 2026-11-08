# Status Dialog implementation update

## Changes

- Restored the original Status Dialog visual proportions and button treatment, adapted to `--rai-*` theme tokens.
- Removed the top accent bar.
- Uses the five supplied package-owned GIFs: `success.gif`, `failed.gif`, `pending.gif`, `error_yellow.gif`, and `location_map.gif`.
- The package publishes GIFs to `public/vendor/admin-ui/gif/status-dialog`.
- The shared Login Blade preview includes the Status Dialog partial.
- `BasePage` exposes the API through `this.statusDialog`; the Host application owns all callback operations.

## Include the dialog

The Login preview already includes it. For another Host page/layout, include it once:

```blade
@include('admin-ui::dialogs.status-dialog')
```

## API examples

```javascript
this.statusDialog.success({
    title: 'Login Successful',
    message: 'Your account has been verified.',
    onOk: () => console.log('Success OK callback'),
});

this.statusDialog.failed({
    title: 'Login Failed',
    message: 'Invalid email or password.',
    onOk: () => console.log('Failed OK callback'),
});

this.statusDialog.pending({
    title: 'Verification Pending',
    message: 'Please wait while we verify your account.',
    onOk: () => console.log('Pending OK callback'),
});

this.statusDialog.warning({
    title: 'Duplicate Session Detected',
    message: 'Delete the previous session before continuing?',
    yesText: 'Yes, Delete',
    cancelText: 'Cancel',
    onYes: () => console.log('Yes callback'),
    onCancel: () => console.log('Cancel callback'),
});

this.statusDialog.location({
    title: 'Allow Location Permission!',
    message: 'Location access is required to continue.',
    onOk: () => console.log('Location OK callback'),
});
```

`isCancellable` controls whether the backdrop and Escape key can dismiss the dialog. `autoClose` is an optional duration in milliseconds for the single-button dialogs.

## Login page test helper

The starter `LoginPage.js` exposes a temporary DevTools helper after the page initializes:

```javascript
adminUiLoginPage.testStatusDialog('success');
adminUiLoginPage.testStatusDialog('failed');
adminUiLoginPage.testStatusDialog('pending');
adminUiLoginPage.testStatusDialog('warning');
adminUiLoginPage.testStatusDialog('location');
```

For `warning`, click Yes and Cancel separately and verify the corresponding console callback. This helper is intended for preview/testing and can be removed from the Host starter file after verification.

## Update procedure

1. Replace the package files from this update.
2. Publish the shared assets:

   ```bash
   php artisan vendor:publish --tag=admin-ui-core --force
   ```

3. Clear Laravel caches:

   ```bash
   php artisan optimize:clear
   ```

4. Rebuild Host assets:

   ```bash
   npm run build
   ```

5. Open `/login`, hard-refresh with `Ctrl + Shift + R`, and test the five examples from DevTools.
