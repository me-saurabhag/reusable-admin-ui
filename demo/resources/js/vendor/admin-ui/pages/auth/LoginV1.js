import BasePage from '../../core/BasePage.js';

/** Login V1 presentation interactions only. Authentication stays in the host app. */
class LoginV1 extends BasePage {
    constructor() {
        super('[data-admin-ui-page="auth-login-v1"]');
    }

    init() {
        if (!super.init()) return false;

        this.passwordInput = this.query('[data-password-input]');
        this.passwordToggle = this.query('[data-password-toggle]');

        this.registerEvents();
        return true;
    }

    registerEvents() {
        this.on(this.passwordToggle, 'click', () => this.togglePasswordVisibility());
    }

    togglePasswordVisibility() {
        if (!this.passwordInput || !this.passwordToggle) return;

        const isPassword = this.passwordInput.type === 'password';
        this.passwordInput.type = isPassword ? 'text' : 'password';
        this.passwordToggle.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
        this.passwordToggle.setAttribute(
            'aria-label',
            isPassword ? 'Hide password' : 'Show password'
        );
        this.passwordToggle.classList.toggle('active', isPassword);
    }

}

function bootLoginPage() {
    const page = new LoginV1();
    if (page.init()) window.adminUiLoginPage = page;
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootLoginPage, { once: true });
} else {
    bootLoginPage();
}
