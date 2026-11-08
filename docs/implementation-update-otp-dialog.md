# OTP Dialog — Implementation Update

## Package files
- `resources/views/dialogs/otp-modal.blade.php`
- `resources/css/components/otp-dialog.css`
- `resources/js/dialogs/OtpManager.js`

The OTP dialog owns only presentation, digit entry, validation of the entered format, loading state and resend countdown. The Host application owns OTP generation, delivery, server-side verification, mobile-number changes and navigation.

## Top image configuration

In the Host `config/admin-ui.php`, under `auth`:

```php
'otp_dialog' => [
    'enabled' => true,
    'top_image' => 'https://bot.kotfumes.com/assets/app/images/otp_top_graphic.webp',
    'otp_length' => 6,
    'resend_timer' => 120,
],
```

Change `top_image` to another image URL when required. Set it to `null` or an empty string to hide the banner. The image can also be overridden for one opening using `topImage`.

## Include and publish

The shared auth layout includes the OTP partial when `admin-ui.auth.otp_dialog.enabled` is true. For a custom page use:

```blade
@include('admin-ui::dialogs.otp-modal')
```

Publish assets:

```bash
php artisan vendor:publish --tag=admin-ui-core --force
php artisan optimize:clear
npm run build
```

Or publish only OTP JS/CSS:

```bash
php artisan vendor:publish --tag=admin-ui-otp-dialog --force
```

The Login CSS entry imports the published `vendor/admin-ui/otp-dialog.css` file.

## Host implementation

```js
import OtpManager from '../vendor/admin-ui/dialogs/OtpManager.js';

const otpManager = new OtpManager();

otpManager.open({
    mobile: '+91 XXXXXX4589',
    timer: 120,
    isCancellable: false,
    onVerify: async (otp) => {
        // Host-owned API request. Throw/reject on failure.
        await ApiClient.post('/api/auth/otp/verify', { otp });
        otpManager.close(); // Host decides when successful verification closes it.
    },
    onResend: async () => {
        await ApiClient.post('/api/auth/otp/resend', { mobile: '+91XXXXXXXXXX' });
    },
    onEditMobile: () => {
        // Open the Host application's mobile-number edit flow.
    },
    onClose: () => {
        // Optional cleanup after modal has fully closed.
    },
    onError: (message, title) => window.AdminUiToast?.error(message, title),
});
```

`onVerify` receives the entered OTP string. `onResend`, `onEditMobile` and `onClose` are Host callbacks. The dialog does not assume an API endpoint or automatically close after verification.

## Login Page test

The Host LoginPage includes a callback demo. In the browser console run:

```js
adminUiLoginPage.testOtpDialog();
```

This demo uses simulated callbacks only. It does not send or verify a real OTP. Use any six digits to test the success callback. Resend countdown is shortened to 10 seconds for this test.
