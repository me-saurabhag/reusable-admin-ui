import { Modal } from 'bootstrap';

/**
 * OtpManager
 * Reusable OTP presentation/input workflow. The Host owns OTP API/business logic.
 */
export default class OtpManager {
    constructor(options = {}) {
        this.modalId = options.modalId ?? 'admin-ui-otp-modal';
        this.defaultOtpLength = options.otpLength ?? null;
        this.defaultTimer = options.timer ?? null;
        this.defaultTopImage = options.topImage ?? null;

        this.timer = null;
        this.resendSeconds = 0;
        this.isVerifying = false;
        this.isResending = false;
        this.errorTimeout = null;
        this.abort = new AbortController();
        this.modalElement = document.getElementById(this.modalId);

        if (!this.modalElement) {
            throw new Error(`OTP modal '${this.modalId}' was not found. Include @include('admin-ui::dialogs.otp-modal') in the page.`);
        }

        this.cacheElements();
        this.defaultOtpLength ??= this.inputs.length;
        if (this.inputs.length !== this.defaultOtpLength) {
            throw new Error(`OTP modal has ${this.inputs.length} inputs, but otpLength is ${this.defaultOtpLength}.`);
        }
        this.defaultTimer ??= Number(this.modalElement.dataset.defaultTimer ?? 120);
        this.defaultTopImage ??= this.modalElement.dataset.defaultTopImage ?? '';
        this.config = this.buildConfig();

        this.bootstrapModal = Modal.getOrCreateInstance(this.modalElement, {
            backdrop: 'static', keyboard: false, focus: true,
        });

        const opts = { signal: this.abort.signal };
        this.modalElement.addEventListener('hide.bs.modal', () => {
            const active = document.activeElement;
            if (active instanceof HTMLElement && this.modalElement.contains(active)) active.blur();
        }, opts);
        this.modalElement.addEventListener('shown.bs.modal', () => this.inputs[0]?.focus(), opts);
        this.modalElement.addEventListener('hidden.bs.modal', () => this.handleModalHidden(), opts);
        this.bindEvents();
    }

    cacheElements() {
        const q = selector => this.modalElement.querySelector(selector);
        this.titleElement = q('.otp-title');
        this.subtitleElement = q('[data-otp-subtitle]');
        this.mobileElement = q('[data-otp-mobile]');
        this.verifyButton = q('[data-otp-verify]');
        this.verifyLabel = q('[data-otp-verify-label]');
        this.resendButton = q('[data-otp-resend]');
        this.resendCountdown = q('[data-otp-countdown]');
        this.resendPrompt = q('[data-otp-resend-prompt]');
        this.inputs = [...this.modalElement.querySelectorAll('[data-otp-digit]')];
        this.inputsWrapper = q('[data-otp-inputs]');
        this.editMobileButton = q('[data-otp-edit]');
        this.closeButton = q('[data-otp-close]');
        this.topImage = q('[data-otp-top-image]');

        if (!this.titleElement || !this.subtitleElement || !this.mobileElement ||
            !this.verifyButton || !this.verifyLabel || !this.resendButton ||
            !this.resendCountdown || !this.resendPrompt || !this.inputsWrapper || !this.inputs.length) {
            throw new Error(`OTP modal '${this.modalId}' is missing required data-otp elements.`);
        }
    }

    buildConfig(overrides = {}) {
        const otpLength = overrides.otpLength ?? this.defaultOtpLength;
        return {
            title: 'Verify OTP',
            subtitle: `We have sent a ${otpLength}-digit verification code to`,
            mobile: '', otpLength, timer: this.defaultTimer,
            autoSubmit: false, isCancellable: false,
            topImage: this.defaultTopImage,
            verifyLabel: 'Verify OTP', verifyingLabel: 'Verifying...',
            resendLabel: 'Resend OTP', resendPrompt: "Didn't receive the code?",
            onVerify: null, onResend: null, onEditMobile: null, onClose: null, onError: null,
            ...overrides,
        };
    }

    bindEvents() {
        const opts = { signal: this.abort.signal };
        this.inputs.forEach((input, index) => {
            input.addEventListener('input', event => this.handleInput(event, index), opts);
            input.addEventListener('keydown', event => this.handleKeydown(event, index), opts);
            input.addEventListener('paste', event => this.handlePaste(event), opts);
        });
        this.verifyButton.addEventListener('click', () => this.handleVerify(), opts);
        this.resendButton.addEventListener('click', () => this.handleResend(), opts);
        this.editMobileButton?.addEventListener('click', () => this.config.onEditMobile?.(), opts);
        this.closeButton?.addEventListener('click', () => this.close(), opts);
    }

    open(options = {}) {
        this.config = this.buildConfig(options);
        if (this.config.otpLength !== this.inputs.length) {
            throw new Error(`This OTP dialog has ${this.inputs.length} boxes. Set otpLength to ${this.inputs.length}.`);
        }

        this.titleElement.textContent = this.config.title;
        this.subtitleElement.textContent = this.config.subtitle;
        this.mobileElement.textContent = this.config.mobile;
        this.verifyLabel.textContent = this.config.verifyLabel;
        this.resendPrompt.textContent = this.config.resendPrompt;
        this.resendButton.firstChild.textContent = `${this.config.resendLabel} `;

        const imageUrl = String(this.config.topImage ?? '').trim();
        if (this.topImage) {
            this.topImage.hidden = !imageUrl;
            if (imageUrl) this.topImage.src = imageUrl;
            else this.topImage.removeAttribute('src');
        }
        this.closeButton.hidden = !this.config.isCancellable;
        this.editMobileButton.hidden = typeof this.config.onEditMobile !== 'function';
        this.bootstrapModal._config.backdrop = this.config.isCancellable ? true : 'static';
        this.bootstrapModal._config.keyboard = Boolean(this.config.isCancellable);

        this.stopTimer();
        this.reset({ focus: false });
        this.startTimer();
        this.bootstrapModal.show();
    }

    close() { this.bootstrapModal.hide(); }

    handleModalHidden() {
        this.stopTimer();
        this.clearError();
        this.clearOtp({ focus: false });
        this.config.onClose?.();
    }

    handleInput(event, index) {
        const input = event.currentTarget;
        this.clearError();
        input.value = input.value.replace(/\D/g, '').slice(0, 1);
        if (input.value && index < this.inputs.length - 1) this.inputs[index + 1].focus();
        this.updateVerifyButton();
        if (this.config.autoSubmit && this.getOtp().length === this.config.otpLength) this.handleVerify();
    }

    handleKeydown(event, index) {
        if (event.key === 'Enter') {
            event.preventDefault();
            if (this.getOtp().length === this.config.otpLength) this.handleVerify();
            return;
        }
        if (event.key === 'Backspace' && !this.inputs[index].value && index > 0) this.inputs[index - 1].focus();
        if (event.key === 'ArrowLeft' && index > 0) this.inputs[index - 1].focus();
        if (event.key === 'ArrowRight' && index < this.inputs.length - 1) this.inputs[index + 1].focus();
    }

    handlePaste(event) {
        event.preventDefault();
        this.clearError();
        const clipboard = event.clipboardData ?? window.clipboardData;
        const otp = clipboard.getData('text').replace(/\D/g, '').slice(0, this.config.otpLength);
        this.clearOtp({ focus: false });
        [...otp].forEach((digit, index) => { if (this.inputs[index]) this.inputs[index].value = digit; });
        const nextEmpty = this.inputs.find(input => !input.value);
        (nextEmpty ?? this.inputs[this.inputs.length - 1]).focus();
        this.updateVerifyButton();
        if (this.config.autoSubmit && this.getOtp().length === this.config.otpLength) this.handleVerify();
    }

    async handleVerify() {
        if (this.isVerifying) return;
        const validation = this.validateOtp();
        if (!validation.valid) { this.showError(); this.notifyError(validation.message, 'Invalid OTP'); return; }
        if (typeof this.config.onVerify !== 'function') { this.notifyError('OTP verification handler is not configured.'); return; }

        this.isVerifying = true;
        this.setLoading(true);
        try {
            await this.config.onVerify(this.getOtp());
        } catch (error) {
            this.showError();
            this.notifyError(error?.message ?? 'Verification failed');
        } finally {
            this.isVerifying = false;
            this.setLoading(false);
        }
    }

    async handleResend() {
        if (this.isResending || this.resendSeconds > 0) return;
        if (typeof this.config.onResend !== 'function') { this.notifyError('OTP resend handler is not configured.'); return; }
        this.isResending = true;
        this.updateResendState();
        try {
            await this.config.onResend();
            this.clearError();
            this.clearOtp();
            this.startTimer();
        } catch (error) {
            this.notifyError(error?.message ?? 'Unable to resend OTP');
        } finally {
            this.isResending = false;
            this.updateResendState();
        }
    }

    notifyError(message, title = 'Error') {
        if (typeof this.config.onError === 'function') this.config.onError(message, title);
        else if (typeof window.AdminUiToast?.error === 'function') window.AdminUiToast.error(message, title);
        else console.error(`[OTP] ${title}: ${message}`);
    }

    showError() {
        clearTimeout(this.errorTimeout);
        this.inputsWrapper.classList.remove('is-invalid');
        this.inputs.forEach(input => input.classList.remove('is-invalid'));
        void this.inputsWrapper.offsetWidth;
        this.inputsWrapper.classList.add('is-invalid');
        this.inputs.forEach(input => { input.classList.add('is-invalid'); input.setAttribute('aria-invalid', 'true'); });
        this.errorTimeout = window.setTimeout(() => { this.clearOtp(); this.inputs[0]?.focus(); }, 450);
    }

    clearError() {
        clearTimeout(this.errorTimeout);
        this.errorTimeout = null;
        this.inputsWrapper.classList.remove('is-invalid');
        this.inputs.forEach(input => { input.classList.remove('is-invalid'); input.removeAttribute('aria-invalid'); });
    }

    getOtp() { return this.inputs.map(input => input.value).join(''); }

    clearOtp({ focus = true } = {}) {
        this.inputs.forEach(input => { input.value = ''; });
        this.updateVerifyButton();
        if (focus && this.modalElement.classList.contains('show')) this.inputs[0]?.focus();
    }

    validateOtp() {
        const otp = this.getOtp();
        if (otp.length !== this.config.otpLength) return { valid: false, message: `Please enter ${this.config.otpLength} digit OTP.` };
        if (!/^\d+$/.test(otp)) return { valid: false, message: 'OTP must contain only digits.' };
        return { valid: true };
    }

    setLoading(loading) {
        this.verifyButton.disabled = loading || this.getOtp().length !== this.config.otpLength;
        this.resendButton.disabled = loading || this.isResending || this.resendSeconds > 0;
        this.verifyLabel.textContent = loading ? this.config.verifyingLabel : this.config.verifyLabel;
        this.verifyButton.querySelector('svg, i')?.classList.toggle('d-none', loading);
    }

    startTimer() {
        this.stopTimer();
        this.resendSeconds = Math.max(0, Number(this.config.timer) || 0);
        this.updateResendState();
        if (!this.resendSeconds) return;
        this.timer = window.setInterval(() => {
            this.resendSeconds = Math.max(0, this.resendSeconds - 1);
            this.updateResendState();
            if (!this.resendSeconds) this.stopTimer();
        }, 1000);
    }

    stopTimer() {
        if (this.timer !== null) { window.clearInterval(this.timer); this.timer = null; }
    }

    updateResendState() {
        const minutes = Math.floor(this.resendSeconds / 60);
        const seconds = this.resendSeconds % 60;
        this.resendCountdown.textContent = this.resendSeconds > 0
            ? `(${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')})` : '';
        this.resendButton.disabled = this.isVerifying || this.isResending || this.resendSeconds > 0;
    }

    reset({ focus = false } = {}) {
        this.clearError();
        this.clearOtp({ focus });
        this.isVerifying = false;
        this.isResending = false;
        this.setLoading(false);
        this.updateResendState();
    }

    destroy() {
        this.stopTimer();
        clearTimeout(this.errorTimeout);
        this.abort.abort();
        this.bootstrapModal.dispose();
    }

    updateVerifyButton() {
        this.verifyButton.disabled = this.isVerifying || this.getOtp().length !== this.config.otpLength;
    }
}

if (typeof window !== 'undefined') window.AdminUiOtpManager ??= OtpManager;
