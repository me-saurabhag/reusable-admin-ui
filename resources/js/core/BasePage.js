/**
 * Minimal shared page foundation.
 *
 * Keep page-specific services (API, dialogs, location, etc.) out of this
 * class. Import only the services a page actually needs.
 */
import Toast from './Toast.js';

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
        this.toast = toast ?? (typeof window !== 'undefined' ? (window.AdminUiToast ?? Toast) : Toast);
        this.loader = loader ?? (typeof window !== 'undefined' ? (window.AdminUiLoader ?? null) : null);
        this.abortController = new AbortController();

        this.form = null;
        this.submitButton = null;

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

    /**
     * Connect a form to the common helpers and expose those helpers directly
     * on the form element for Host Application use.
     */
    attachFormHelpers(form, submitButton = null) {
        if (!form?.elements) return false;

        this.form = form;
        this.submitButton = submitButton
            ?? form.querySelector('button[type="submit"], input[type="submit"]');

        const helpers = {
            getFormValues: () => this.getFormValues(),
            getFormData: () => this.getFormData(),
            getFieldValue: (name) => this.getFieldValue(name),
            setFieldValue: (name, value) => this.setFieldValue(name, value),
            clearForm: () => this.clearForm(),
            setFormLoading: (loading) => this.setFormLoading(loading),
        };

        Object.entries(helpers).forEach(([name, callback]) => {
            Object.defineProperty(form, name, {
                configurable: true,
                value: callback,
            });
        });

        return true;
    }

    /**
     * Return all named form controls as a plain object.
     * Repeated field names are returned as arrays.
     */
    getFormValues() {
        if (!this.form || typeof FormData === 'undefined') return {};

        const values = {};

        for (const [name, value] of new FormData(this.form).entries()) {
            if (Object.prototype.hasOwnProperty.call(values, name)) {
                values[name] = Array.isArray(values[name])
                    ? [...values[name], value]
                    : [values[name], value];
            } else {
                values[name] = value;
            }
        }

        return values;
    }

    /** Return the native FormData object for file and multipart requests. */
    getFormData() {
        return this.form && typeof FormData !== 'undefined'
            ? new FormData(this.form)
            : null;
    }

    /** Get one field by its name attribute. */
    getFieldValue(name) {
        if (!this.form || !name) return '';

        const field = this.form.elements.namedItem(name);
        if (!field) return '';

        // RadioNodeList covers groups of radio inputs with the same name.
        if (typeof RadioNodeList !== 'undefined' && field instanceof RadioNodeList) {
            return field.value ?? '';
        }

        if (field.type === 'checkbox') {
            return field.checked ? field.value : '';
        }

        return field.value ?? '';
    }

    /** Set one field by its name attribute. */
    setFieldValue(name, value) {
        if (!this.form || !name) return false;

        const field = this.form.elements.namedItem(name);
        if (!field) return false;

        if (typeof RadioNodeList !== 'undefined' && field instanceof RadioNodeList) {
            Array.from(field).forEach((item) => {
                if (item.type === 'radio') {
                    item.checked = String(item.value) === String(value);
                } else if (item.type === 'checkbox') {
                    const selected = Array.isArray(value) ? value : [value];
                    item.checked = selected.map(String).includes(String(item.value));
                }
            });
            return true;
        }

        if (field.type === 'checkbox') {
            field.checked = typeof value === 'boolean'
                ? value
                : String(field.value) === String(value);
            return true;
        }

        field.value = value ?? '';
        return true;
    }

    /** Reset all controls to their original HTML default values. */
    clearForm() {
        if (!this.form) return false;
        this.form.reset();
        return true;
    }

    /** Toggle the configured form submit button's loading/disabled state. */
    setFormLoading(loading) {
        const button = this.submitButton;
        if (!button) return false;

        const isLoading = Boolean(loading);

        if (!button.dataset.defaultLabel) {
            button.dataset.defaultLabel = button.tagName === 'INPUT'
                ? button.value
                : button.textContent.trim();
        }

        button.disabled = isLoading;
        button.setAttribute('aria-busy', String(isLoading));

        const loadingLabel = button.dataset.loadingLabel || 'Please wait...';

        if (button.tagName === 'INPUT') {
            button.value = isLoading ? loadingLabel : button.dataset.defaultLabel;
        } else {
            button.textContent = isLoading ? loadingLabel : button.dataset.defaultLabel;
        }

        return true;
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
