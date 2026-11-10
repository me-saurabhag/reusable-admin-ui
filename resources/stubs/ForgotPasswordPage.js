import BasePage from '../vendor/admin-ui/core/BasePage.js';
import OtpManager from '../vendor/admin-ui/dialogs/OtpManager.js';

/**
 * Host-side Forgot Password page starter.
 *
 * This class prepares the form and exposes reusable form helpers directly
 * on the form element. The Host Application owns the submit event, API call,
 * server-side validation, OTP workflow, and response handling.
 */
export default class ForgotPasswordPage extends BasePage {
    constructor() {
        super();

        this.root = document.querySelector(
            '[data-admin-ui-page="auth-forgot-password"]'
        );

        this.form = this.root?.querySelector('#forgotPasswordForm') ?? null;
        this.submitButton = this.root?.querySelector('#btnForgotPassword') ?? null;

        this.otpDialog = document.getElementById('admin-ui-otp-modal')
            ? new OtpManager()
            : null;
    }

    init() {
        if (!this.root || !this.form || !super.init()) return false;

        // Makes getFormValues(), getFieldValue(), setFieldValue(),
        // clearForm(), setFormLoading(), and getFormData() available
        // directly on the form element for the Host Application.
        this.attachFormHelpers(this.form, this.submitButton);

        this.bindPasswordToggles();

        // Intentionally do not listen for form submission here.
        // The Host Application owns the submit event and its full workflow.
        return true;
    }

    bindPasswordToggles() {
        this.root.querySelectorAll('[data-password-toggle]').forEach((button) => {
            this.on(button, 'click', () => {
                const input = button.parentElement?.querySelector(
                    '[data-password-input]'
                );

                if (!input) return;

                const show = input.type === 'password';

                input.type = show ? 'text' : 'password';
                button.textContent = show ? 'Hide' : 'Show';
                button.setAttribute('aria-pressed', String(show));
                button.setAttribute(
                    'aria-label',
                    show ? 'Hide password' : 'Show password'
                );
            });
        });
    }
}

function boot() {
    const page = new ForgotPasswordPage();

    if (page.init()) {
        // Keep the instance alive for its managed UI event listeners.
        // Host Application code does not need this reference; it uses the form.
        window.adminUiForgotPasswordPageInstance = page;
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
    boot();
}
