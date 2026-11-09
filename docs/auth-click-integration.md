# Authentication button-click integration

Login, Registration and Forgot Password use explicit `type="button"` controls. The published page classes listen to button `click` events and dispatch a Host-facing custom event. They do not perform native form submission.

Before dispatching the custom event, each page calls `form.reportValidity()` so required fields and browser-native input constraints are still checked.

## Host events

- Login: `admin-ui:login-submit`
- Registration: `admin-ui:register-submit`
- Forgot Password: `admin-ui:forgot-password-submit`

Each event bubbles from its form and includes `detail.form` and `detail.formData`. Login additionally includes `email` and `password`. All three include `otpDialog`, which is an initialized `OtpManager` instance when the OTP modal is present; otherwise it is `null`.

Example Host listener:

```js
document.addEventListener('admin-ui:login-submit', async (event) => {
    const { formData, email, password, otpDialog } = event.detail;

    // Send formData with the Host application's API client.
    // Open OTP when required:
    // otpDialog?.open({ mobile: email, onVerify: async (otp) => { ... } });
});
```

## OTP manager import

The page stubs import the default export explicitly:

```js
import OtpManager from '../vendor/admin-ui/dialogs/OtpManager.js';

const otpDialog = new OtpManager();
```

Do not assume `OtpManager` is a global variable. The module also exposes `window.AdminUiOtpManager` for integrations that deliberately use the global name, but ES module imports are recommended.

## Host integration note

The package publishes starter page classes into `resources/js/pages/`. If you have customized those files, do not blindly overwrite them. Either merge the changes or back them up before running `vendor:publish --tag=admin-ui-auth --force`.


## Toast notifications

Toast is included in the `admin-ui-core` publish set and is imported by `BasePage.js`. Page classes extending BasePage can use it without a separate global setup:

```js
this.toast.success('Signed in successfully');
this.toast.info('Please wait', 'Information', 2000);
this.toast.warning('Check your details');
this.toast.error('Unable to sign in');
```

The optional arguments are title and auto-dismiss duration in milliseconds. Toast content is inserted as text, not HTML. The Host application should import `resources/css/vendor/admin-ui/components/toast.css` from its Vite CSS entry (or use the corresponding package CSS import shown in the README).
