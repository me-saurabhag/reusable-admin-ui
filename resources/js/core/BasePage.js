/**
 * Minimal shared page foundation.
 *
 * Keep page-specific services (API, dialogs, location, etc.) out of this
 * class. Import only the services a page actually needs.
 */
export default class BasePage {
    constructor(options = {}) {
        // Backward-compatible support for selector strings and DOM roots.
        if (typeof options === 'string') {
            options = {
                root: typeof document !== 'undefined'
                    ? (document.querySelector(options) ?? document)
                    : null,
            };
        } else if (options?.querySelector) {
            options = { root: options };
        }

        const { root = null, toast = null, loader = null } = options ?? {};

        this.root = root ?? (typeof document !== 'undefined' ? document : null);
        this.toast = toast ?? (typeof window !== 'undefined' ? (window.AdminUiToast ?? null) : null);
        this.loader = loader ?? (typeof window !== 'undefined' ? (window.AdminUiLoader ?? null) : null);
        this.abortController = new AbortController();

        this.handleHeaderAction = this.handleHeaderAction.bind(this);
        this.handleProfileAction = this.handleProfileAction.bind(this);

        this.registerGlobalEvents();
    }

    init() {
        return true;
    }

    registerGlobalEvents() {
        if (typeof document === 'undefined') return;

        document.addEventListener('admin-ui:header-action', this.handleHeaderAction, {
            signal: this.abortController.signal,
        });
        document.addEventListener('admin-ui:profile-action', this.handleProfileAction, {
            signal: this.abortController.signal,
        });
    }

    on(target, eventName, callback, options = {}) {
        if (!target?.addEventListener || typeof callback !== 'function') return false;

        target.addEventListener(eventName, callback, {
            ...options,
            signal: this.abortController.signal,
        });
        return true;
    }

    setRoot(root) {
        if (root?.querySelector) this.root = root;
        return this;
    }

    query(selector) {
        return this.root?.querySelector(selector) ?? null;
    }

    queryAll(selector) {
        return this.root?.querySelectorAll(selector) ?? [];
    }

    setToast(toast) {
        this.toast = toast ?? null;
        return this;
    }

    setLoader(loader) {
        this.loader = loader ?? null;
        return this;
    }

    handleHeaderAction(event) {
        const action = event?.detail?.action;
        if (action) this.onHeaderAction(action, event);
    }

    handleProfileAction(event) {
        const action = event?.detail?.action;
        if (action) this.onProfileAction(action, event);
    }

    onHeaderAction() {
        // Override in a page class when required.
    }

    onProfileAction() {
        // Override in a page class when required.
    }

    toLabel(value) {
        return String(value ?? '')
            .replace(/[_-]+/g, ' ')
            .replace(/\b\w/g, character => character.toUpperCase());
    }

    destroy() {
        if (!this.abortController.signal.aborted) this.abortController.abort();
    }
}
