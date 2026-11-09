import BasePage from '../vendor/admin-ui/core/BasePage.js';
import OtpManager from '../vendor/admin-ui/dialogs/OtpManager.js';

/** Host-side registration starter. Add your API, validation and OTP workflow here. */
export default class RegisterPage extends BasePage {
    constructor() {
        super();
        this.root = document.querySelector('[data-admin-ui-page="auth-register"]');
        this.form = this.root?.querySelector('#registrationForm') ?? null;
        this.submitButton = this.root?.querySelector('#btnRegister') ?? null;
        this.otpDialog = document.getElementById('admin-ui-otp-modal') ? new OtpManager() : null;
    }

    init() {
        if (!this.root || !super.init()) return false;
        this.on(this.submitButton, 'click', () => this.handleSubmit());
        return true;
    }

    handleSubmit() {
        if (!this.form?.reportValidity()) return;
        if (this.root.dataset.demoMode === 'true') {
            this.toast.info('This is a design preview. Registration is not connected.', 'Preview mode');
            return;
        }

        this.form.dispatchEvent(new CustomEvent('admin-ui:register-submit', {
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
    const page = new RegisterPage();
    if (page.init()) window.adminUiRegisterPage = page;
}
if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot, { once: true });
else boot();
