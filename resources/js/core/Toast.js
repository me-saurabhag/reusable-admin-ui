/**
 * Lightweight application toast notifications.
 *
 * The host application owns business decisions; this class only displays
 * short-lived feedback. It uses native DOM/CSS and does not depend on Bootstrap.
 */
export default class Toast {
    static container = null;
    static sequence = 0;
    static timers = new Map();

    static success(message, title = 'Success', duration = 3500) {
        return this.show('success', message, title, duration);
    }

    static info(message, title = 'Information', duration = 3500) {
        return this.show('info', message, title, duration);
    }

    static warning(message, title = 'Warning', duration = 4500) {
        return this.show('warning', message, title, duration);
    }

    static error(message, title = 'Something went wrong', duration = 5000) {
        return this.show('error', message, title, duration);
    }

    // Backward-friendly alias for callers that use "failed".
    static failed(message, title = 'Failed', duration = 5000) {
        return this.error(message, title, duration);
    }

    static show(type, message, title = '', duration = 3500) {
        if (typeof document === 'undefined' || !document.body) return null;

        const safeType = ['success', 'info', 'warning', 'error'].includes(type) ? type : 'info';
        const container = this.getContainer();
        const id = ++this.sequence;
        const toast = document.createElement('section');
        toast.className = `rai-toast rai-toast--${safeType}`;
        toast.setAttribute('role', safeType === 'error' ? 'alert' : 'status');
        toast.setAttribute('aria-live', safeType === 'error' ? 'assertive' : 'polite');
        toast.dataset.toastId = String(id);

        const icon = document.createElement('span');
        icon.className = 'rai-toast__icon';
        icon.setAttribute('aria-hidden', 'true');
        icon.textContent = ({ success: '✓', info: 'i', warning: '!', error: '×' })[safeType];

        const content = document.createElement('div');
        content.className = 'rai-toast__content';

        if (title) {
            const heading = document.createElement('div');
            heading.className = 'rai-toast__title';
            heading.textContent = String(title);
            content.appendChild(heading);
        }

        const text = document.createElement('div');
        text.className = 'rai-toast__message';
        text.textContent = String(message ?? '');
        content.appendChild(text);

        const close = document.createElement('button');
        close.className = 'rai-toast__close';
        close.type = 'button';
        close.setAttribute('aria-label', 'Dismiss notification');
        close.textContent = '×';
        close.addEventListener('click', () => this.dismiss(id));

        toast.append(icon, content, close);
        container.appendChild(toast);

        // Trigger the enter transition after the browser has attached the node.
        window.requestAnimationFrame(() => toast.classList.add('is-visible'));

        const timeout = Number(duration);
        if (Number.isFinite(timeout) && timeout > 0) {
            const timer = window.setTimeout(() => this.dismiss(id), timeout);
            this.timers.set(id, timer);
        }

        return id;
    }

    static dismiss(id) {
        const toast = document.querySelector(`[data-toast-id="${String(id)}"]`);
        const timer = this.timers.get(id);

        if (timer) window.clearTimeout(timer);
        this.timers.delete(id);
        if (!toast) return;

        toast.classList.remove('is-visible');
        window.setTimeout(() => toast.remove(), 220);
    }

    static clear() {
        this.timers.forEach(timer => window.clearTimeout(timer));
        this.timers.clear();
        this.container?.replaceChildren();
    }

    static getContainer() {
        if (this.container?.isConnected) return this.container;

        const container = document.createElement('div');
        container.className = 'rai-toast-container';
        container.setAttribute('aria-label', 'Notifications');
        document.body.appendChild(container);
        this.container = container;

        return container;
    }
}

if (typeof window !== 'undefined') {
    window.AdminUiToast ??= Toast;
}
