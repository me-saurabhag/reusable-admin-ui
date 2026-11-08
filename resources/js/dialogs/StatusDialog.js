import { Modal } from 'bootstrap';

/**
 * StatusDialog
 * The package owns presentation only. The Host application owns operations
 * and supplies callbacks such as onOk, onYes and onCancel.
 */
export default class StatusDialog {
    static modal = null;
    static timeout = null;
    static pendingConfig = null;
    static element = null;

    static success({ title = 'Congratulations!', message = '', isCancellable = false, autoClose = null, onOk = null } = {}) {
        this.#show({ type: 'success', title, message, isCancellable, autoClose, primaryButton: { text: 'OK', callback: onOk } });
    }

    static location({ title = 'Allow Location Permission!', message = 'Enable location access to secure your transactions and protect your account from unauthorized access.', isCancellable = false, autoClose = null, onOk = null } = {}) {
        this.#show({ type: 'location', title, message, isCancellable, autoClose, primaryButton: { text: 'OK', callback: onOk } });
    }

    static failed({ title = 'Error', message = 'Transaction Failed', isCancellable = false, autoClose = null, onOk = null } = {}) {
        this.#show({ type: 'failed', title, message, isCancellable, autoClose, primaryButton: { text: 'OK', callback: onOk } });
    }

    static pending({ title = 'Transaction Accepted', message = '', isCancellable = false, autoClose = null, onOk = null } = {}) {
        this.#show({ type: 'pending', title, message, isCancellable, autoClose, primaryButton: { text: 'OK', callback: onOk } });
    }

    static warning({
        title = 'Duplicate Session Detected',
        message = 'An active session already exists. Do you want to delete your previous sessions before creating a new one?',
        isCancellable = true,
        onYes = null,
        onCancel = null,
        yesText = 'Yes',
        cancelText = 'Cancel',
    } = {}) {
        this.#show({
            type: 'warning', title, message, isCancellable,
            primaryButton: { text: yesText, callback: onYes },
            secondaryButton: { text: cancelText, callback: onCancel },
        });
    }

    static dismiss() {
        this.#clearTimeout();
        this.pendingConfig = null;
        if (this.modal && this.element?.classList.contains('show')) this.modal.hide();
    }

    static #show(config) {
        const element = document.getElementById('admin-ui-status-dialog');
        if (!element) {
            console.warn("StatusDialog: include @include('admin-ui::dialogs.status-dialog') in the page layout.");
            return;
        }

        this.element = element;
        this.#clearTimeout();

        // Blur a focused dialog control before Bootstrap applies aria-hidden.
        // The dataset guard ensures this listener is registered only once.
        if (element.dataset.raiFocusCleanupBound !== 'true') {
            element.addEventListener('hide.bs.modal', () => {
                const activeElement = document.activeElement;

                if (activeElement instanceof HTMLElement && element.contains(activeElement)) {
                    activeElement.blur();
                }
            });

            element.dataset.raiFocusCleanupBound = 'true';
        }

        if (this.modal && element.classList.contains('show')) {
            this.pendingConfig = config;
            element.addEventListener('hidden.bs.modal', () => {
                const next = this.pendingConfig;
                this.pendingConfig = null;
                if (next) this.#present(next);
            }, { once: true });
            this.modal.hide();
            return;
        }

        this.#present(config);
    }

    static #present(config) {
        const element = this.element;
        if (!element) return;

        const type = ['success', 'failed', 'pending', 'warning', 'location'].includes(config.type)
            ? config.type : 'success';

        const content = element.querySelector('[data-status-content]');
        const title = element.querySelector('[data-status-title]');
        const message = element.querySelector('[data-status-message]');
        const image = element.querySelector('[data-status-gif]');

        content?.classList.remove(
            'rai-status-dialog-success', 'rai-status-dialog-failed',
            'rai-status-dialog-pending', 'rai-status-dialog-warning',
            'rai-status-dialog-location'
        );
        content?.classList.add(`rai-status-dialog-${type}`);

        if (title) title.textContent = config.title ?? '';
        if (message) {
            message.textContent = config.message ?? '';
            message.hidden = !String(config.message ?? '').trim();
        }

        if (image) {
            const key = `gif${type.charAt(0).toUpperCase()}${type.slice(1)}`;
            const gifUrl = image.dataset[key];
            if (gifUrl) image.src = gifUrl;
        }

        this.#configureButton(element.querySelector('[data-status-primary]'), config.primaryButton);
        this.#configureButton(element.querySelector('[data-status-secondary]'), config.secondaryButton);

        this.modal = Modal.getOrCreateInstance(element, {
            backdrop: config.isCancellable ? true : 'static',
            keyboard: Boolean(config.isCancellable),
            focus: true,
        });
        this.modal._config.backdrop = config.isCancellable ? true : 'static';
        this.modal._config.keyboard = Boolean(config.isCancellable);

        element.addEventListener('hidden.bs.modal', () => this.#clearTimeout(), { once: true });
        this.modal.show();

        if (Number.isFinite(config.autoClose) && config.autoClose > 0) {
            this.timeout = window.setTimeout(() => this.dismiss(), config.autoClose);
        }
    }

    static #configureButton(button, config) {
        if (!button) return;
        button.onclick = null;
        button.hidden = !config;
        if (!config) return;

        button.textContent = config.text ?? 'OK';
        button.onclick = () => {
            const callback = config.callback;
            if (config.dismiss !== false) this.dismiss();
            if (typeof callback === 'function') callback();
        };
    }

    static #clearTimeout() {
        if (this.timeout !== null) {
            window.clearTimeout(this.timeout);
            this.timeout = null;
        }
    }
}

if (typeof window !== 'undefined') {
    window.AdminUiStatusDialog ??= StatusDialog;
}
