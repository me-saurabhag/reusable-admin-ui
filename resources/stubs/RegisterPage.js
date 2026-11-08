import BasePage from '../vendor/admin-ui/core/BasePage.js';

/** Host-side registration starter. Add your API, validation and OTP workflow here. */
export default class RegisterPage extends BasePage {
    constructor() {
        super();
        this.root = document.querySelector('[data-admin-ui-page="auth-register"]');
        this.form = this.root?.querySelector('#registrationForm') ?? null;
        this.submitButton = this.root?.querySelector('#btnRegister') ?? null;
    }

    init() {
        if (!this.root || !super.init()) return false;
        this.on(this.form, 'submit', event => this.handleSubmit(event));
        return true;
    }

    handleSubmit(event) {
        if (this.root.dataset.demoMode === 'true') {
            event.preventDefault();
            this.toast.info('This is a design preview. Registration is not connected.', 'Preview mode');
            return;
        }
        const registrationEvent = new CustomEvent('admin-ui:register-submit', {
            bubbles: true, cancelable: true,
            detail: { form: this.form, formData: new FormData(this.form) },
        });
        if (!this.form.dispatchEvent(registrationEvent)) event.preventDefault();
    }
}

function boot() {
    const page = new RegisterPage();
    if (page.init()) window.adminUiRegisterPage = page;
}
if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot, { once: true });
else boot();
