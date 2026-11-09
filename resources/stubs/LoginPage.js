import BasePage from '../vendor/admin-ui/core/BasePage.js';
import OtpManager from '../vendor/admin-ui/dialogs/OtpManager.js';

/**
 * LoginPage — host application starter.
 *
 * The package supplies the reusable UI. The host application owns API calls,
 * validation, authentication, OTP/session handling and redirects.
 */
export default class LoginPage extends BasePage {
    constructor() {
        super();
        this.root = document.querySelector('[data-admin-ui-page="auth-login-v1"]');
        this.form = this.root?.querySelector('#loginForm') ?? null;
        this.emailInput = this.root?.querySelector('#emailAddress') ?? null;
        this.passwordInput = this.root?.querySelector('#password') ?? null;
        this.passwordToggle = this.root?.querySelector('[data-password-toggle]') ?? null;
        this.loginButton = this.root?.querySelector('#btnLogin') ?? null;
        this.otpDialog = document.getElementById('admin-ui-otp-modal') ? new OtpManager() : null;
    }

    init() {
        if (!this.root || !super.init()) return false;
        this.registerEvents();
        return true;
    }

    registerEvents() {
        this.on(this.passwordToggle, 'click', () => this.togglePasswordVisibility());
        this.on(this.loginButton, 'click', () => this.handleLoginSubmit());

        this.root.querySelectorAll('[data-social-login]').forEach(button => {
            this.on(button, 'click', event => this.handleSocialLoginClick(event));
        });
    }

    togglePasswordVisibility() {
        if (!this.passwordInput || !this.passwordToggle) return;
        const showPassword = this.passwordInput.type === 'password';
        this.passwordInput.type = showPassword ? 'text' : 'password';
        this.passwordToggle.setAttribute('aria-pressed', String(showPassword));
        this.passwordToggle.setAttribute('aria-label', showPassword ? 'Hide password' : 'Show password');
        this.passwordToggle.classList.toggle('active', showPassword);
    }

    handleLoginSubmit() {
        if (!this.form?.reportValidity()) return;
        if (this.root?.dataset.demoMode === 'true') {
            this.toast.info('This is a design preview. Login is not connected.', 'Preview mode');
            return;
        }

        this.form.dispatchEvent(new CustomEvent('admin-ui:login-submit', {
            bubbles: true,
            cancelable: true,
            detail: {
                form: this.form,
                formData: new FormData(this.form),
                email: this.emailInput?.value ?? '',
                password: this.passwordInput?.value ?? '',
                otpDialog: this.otpDialog,
            },
        }));
    }

    handleSocialLoginClick(clickEvent) {
        const button = clickEvent.currentTarget;
        const provider = button.dataset.socialProvider || 'Social';
        const configured = button.dataset.socialConfigured === 'true';
        const url = button.getAttribute('href');

        if (!configured || !url) {
            clickEvent.preventDefault();
            this.toast.warning(
                (button.dataset.socialUnavailableMessage || ':provider login is not configured yet.').replace(':provider', provider),
                'Not configured'
            );
            return;
        }

        this.toast.info(
            (button.dataset.socialPendingMessage || 'Connecting to :provider...').replace(':provider', provider),
            'Please wait',
            1200
        );

        if (clickEvent.metaKey || clickEvent.ctrlKey || clickEvent.shiftKey ||
            clickEvent.altKey || button.target === '_blank') return;

        clickEvent.preventDefault();
        window.setTimeout(() => window.location.assign(url), 350);
    }
}

function bootLoginPage() {
    const page = new LoginPage();
    if (page.init()) window.adminUiLoginPage = page;
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootLoginPage, { once: true });
} else {
    bootLoginPage();
}
