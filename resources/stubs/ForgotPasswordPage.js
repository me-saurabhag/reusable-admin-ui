import BasePage from '../vendor/admin-ui/core/BasePage.js';
import OtpManager from '../vendor/admin-ui/dialogs/OtpManager.js';

/** Host-side password reset starter. Add your own API and token/OTP workflow. */
export default class ForgotPasswordPage extends BasePage {
    constructor() {
        super();
        this.root = document.querySelector('[data-admin-ui-page="auth-forgot-password"]');
        this.form = this.root?.querySelector('#forgotPasswordForm') ?? null;
        this.submitButton = this.root?.querySelector('#btnForgotPassword') ?? null;
        this.otpDialog = document.getElementById('admin-ui-otp-modal') ? new OtpManager() : null;
    }

    init() {
        if (!this.root || !super.init()) return false;
        this.root.querySelectorAll('[data-password-toggle]').forEach(button => {
            this.on(button, 'click', () => {
                const input = button.parentElement?.querySelector('[data-password-input]');
                if (!input) return;
                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                button.textContent = show ? 'Hide' : 'Show';
                button.setAttribute('aria-pressed', String(show));
            });
        });
        this.on(this.submitButton, 'click', () => this.handleSubmit());
        return true;
    }

    handleSubmit() {
        if (!this.form?.reportValidity()) return;
        if (this.root.dataset.demoMode === 'true') {
            this.toast.info('This is a design preview. Password reset is not connected.', 'Preview mode');
            return;
        }

        this.form.dispatchEvent(new CustomEvent('admin-ui:forgot-password-submit', {
            bubbles: true,
            cancelable: true,
            detail: {
                form: this.form,
                formData: new FormData(this.form),
                otpDialog: this.otpDialog,
            },
        }));
    }
}

function boot() {
    const page = new ForgotPasswordPage();
    if (page.init()) window.adminUiForgotPasswordPage = page;
}
if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot, { once: true });
else boot();
