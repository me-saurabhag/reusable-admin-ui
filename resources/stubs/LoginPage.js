import BasePage from '../vendor/admin-ui/core/BasePage.js';

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
    }

    init() {
        if (!this.root || !super.init()) return false;

        this.registerEvents();
        return true;
    }

    registerEvents() {
        this.on(this.passwordToggle, 'click', () => this.togglePasswordVisibility());
        this.on(this.form, 'submit', (event) => this.handleLoginSubmit(event));

        this.root.querySelectorAll('[data-social-login]').forEach((button) => {
            this.on(button, 'click', (event) => this.handleSocialLoginClick(event));
        });
    }

    togglePasswordVisibility() {
        if (!this.passwordInput || !this.passwordToggle) return;

        const showPassword = this.passwordInput.type === 'password';
        this.passwordInput.type = showPassword ? 'text' : 'password';
        this.passwordToggle.setAttribute('aria-pressed', String(showPassword));
        this.passwordToggle.setAttribute(
            'aria-label',
            showPassword ? 'Hide password' : 'Show password'
        );
        this.passwordToggle.classList.toggle('active', showPassword);
    }

    /**
     * Dispatch a cancelable event for the host application's login handler.
     * The host listener must call event.preventDefault() synchronously when it
     * intends to handle the request with fetch/AJAX. Otherwise native POST runs.
     */
    handleLoginSubmit(submitEvent) {
        // Demo routes are visual previews only; never submit credentials.
        if (this.root?.dataset.demoMode === 'true') {
            submitEvent.preventDefault();
            this.toast.info('This is a design preview. Login is not connected.', 'Preview mode');
            return;
        }

        const loginEvent = new CustomEvent('admin-ui:login-submit', {
            bubbles: true,
            cancelable: true,
            detail: {
                form: this.form,
                formData: new FormData(this.form),
                email: this.emailInput?.value ?? '',
                password: this.passwordInput?.value ?? '',
            },
        });

        if (!this.form.dispatchEvent(loginEvent)) {
            submitEvent.preventDefault();
        }
    }

    /** Show feedback before continuing to the configured social provider URL. */
    handleSocialLoginClick(clickEvent) {
        const button = clickEvent.currentTarget;
        const provider = button.dataset.socialProvider || 'Social';
        const configured = button.dataset.socialConfigured === 'true';
        const url = button.getAttribute('href');

        if (!configured || !url) {
            clickEvent.preventDefault();
            this.toast.warning(
                (button.dataset.socialUnavailableMessage || ':provider login is not configured yet.')
                    .replace(':provider', provider),
                'Not configured'
            );
            return;
        }

        this.toast.info(
            (button.dataset.socialPendingMessage || 'Connecting to :provider...')
                .replace(':provider', provider),
            'Please wait',
            1200
        );

        // Preserve browser-native behaviours such as opening a link in a new tab.
        if (
            clickEvent.metaKey || clickEvent.ctrlKey || clickEvent.shiftKey ||
            clickEvent.altKey || button.target === '_blank'
        ) {
            return;
        }

        clickEvent.preventDefault();
        window.setTimeout(() => window.location.assign(url), 350);
    }
}

function bootLoginPage() {
    const page = new LoginPage();

    if (page.init()) {
        window.adminUiLoginPage = page;
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootLoginPage, { once: true });
} else {
    bootLoginPage();
}
