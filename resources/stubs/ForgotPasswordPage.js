import BasePage from '../vendor/admin-ui/core/BasePage.js';
import OtpManager from '../vendor/admin-ui/dialogs/OtpManager.js';

/**
 * Host-side Forgot Password page starter.
 *
 * The package prepares the form and exposes reusable form helpers.
 * The Host Application listens to the native submit event and owns all
 * submission behavior, including API calls and any OTP workflow.
 */
export default class ForgotPasswordPage extends BasePage {
    constructor() {
        super();

        this.root = document.querySelector(
            '[data-admin-ui-page="auth-forgot-password"]'
        );

        this.form = this.root?.querySelector('#forgotPasswordForm') ?? null;
        this.submitButton = this.root?.querySelector('#btnForgotPassword') ?? null;
        this.otpDialog = document.getElementById('admin-ui-otp-modal') ? new OtpManager() : null;
    }

    init() {
        if (!this.root || !this.form || !super.init()) return false;

        // Makes form.getFormValues() and the other helpers available to the Host.
        this.attachFormHelpers(this.form, this.submitButton);

        this.bindPasswordToggles();

        // The Host Application registers its own native form submit listener.
        // No API request, custom submit event, or OTP dialog is handled here.
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
    if (page.init()) window.adminUiForgotPasswordPage = page;
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
    boot();
}
