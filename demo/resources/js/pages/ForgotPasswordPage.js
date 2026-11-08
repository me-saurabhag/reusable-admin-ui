import BasePage from '../vendor/admin-ui/core/BasePage.js';
import UIManager from '../core/UIManager.js';

// The package BasePage accepts an optional host-provided Toast bridge.
window.AdminUiToast ??= UIManager;

/** Host-side password reset starter. Add your own API and token/OTP workflow. */
export default class ForgotPasswordPage extends BasePage {
    constructor() {
        super();
        this.root = document.querySelector('[data-admin-ui-page="auth-forgot-password"]');
        this.form = this.root?.querySelector('#forgotPasswordForm') ?? null;
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
        this.on(this.form, 'submit', event => this.handleSubmit(event));
        return true;
    }

    handleSubmit(event) {
        if (this.root.dataset.demoMode === 'true') {
            event.preventDefault();
            this.toast.info('This is a design preview. Password reset is not connected.', 'Preview mode');
            return;
        }
        const resetEvent = new CustomEvent('admin-ui:forgot-password-submit', {
            bubbles: true, cancelable: true,
            detail: { form: this.form, formData: new FormData(this.form) },
        });
        if (!this.form.dispatchEvent(resetEvent)) event.preventDefault();
    }
}

function boot() {
    const page = new ForgotPasswordPage();
    if (page.init()) window.adminUiForgotPasswordPage = page;
}
if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot, { once: true });
else boot();
