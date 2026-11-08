import { Offcanvas as BootstrapOffcanvas } from 'bootstrap';

/**
 * Host-facing bridge for the shared Admin UI form offcanvas.
 * The package collects FormData; the host owns validation and persistence.
 */
export default class AdminUiOffcanvas {
    static instances = new WeakMap();

    constructor(element, options = {}) {
        if (!(element instanceof HTMLElement)) {
            throw new TypeError('AdminUiOffcanvas requires an offcanvas HTMLElement.');
        }

        this.element = element;
        this.form = element.querySelector('[data-rai-offcanvas-form]');
        this.submitButton = element.querySelector('[data-rai-offcanvas-submit]');
        this.submitLabel = element.querySelector('.rai-offcanvas__submit-label');
        this.defaultSubmitLabel = this.submitLabel?.textContent?.trim() || 'Save changes';
        this.loadingLabel = options.loadingLabel || 'Saving…';
        this.disposed = false;

        if (!this.form) {
            throw new Error('Admin UI Offcanvas requires a form element.');
        }

        this.instance = BootstrapOffcanvas.getOrCreateInstance(element);
        this.onSubmit = this.handleSubmit.bind(this);
        this.form.addEventListener('submit', this.onSubmit);
        AdminUiOffcanvas.instances.set(element, this);
    }

    handleSubmit(event) {
        event.preventDefault();
        if (this.isLoading() || !this.form.reportValidity()) return;

        const formData = new FormData(this.form);
        this.setLoading(true);

        const submitEvent = new CustomEvent('rai:offcanvas:submit', {
            bubbles: true,
            cancelable: false,
            detail: {
                formData,
                form: this.form,
                offcanvas: this,
            },
        });

        this.element.dispatchEvent(submitEvent);
    }

    setLoading(loading, label = null) {
        const active = Boolean(loading);
        this.element.classList.toggle('is-loading', active);
        this.element.setAttribute('aria-busy', active ? 'true' : 'false');

        if (this.submitButton) this.submitButton.disabled = active;
        if (this.submitLabel) {
            this.submitLabel.textContent = active ? (label || this.loadingLabel) : this.defaultSubmitLabel;
        }
    }

    isLoading() {
        return this.element.classList.contains('is-loading');
    }

    open() {
        this.instance.show();
    }

    close() {
        this.setLoading(false);
        this.instance.hide();
    }

    reset() {
        this.form.reset();
        this.setLoading(false);
        this.form.querySelectorAll('.is-invalid').forEach((field) => field.classList.remove('is-invalid'));
    }

    destroy() {
        if (this.disposed) return;
        this.form.removeEventListener('submit', this.onSubmit);
        this.instance.dispose();
        AdminUiOffcanvas.instances.delete(this.element);
        this.disposed = true;
    }

    static get(target) {
        const element = typeof target === 'string' ? document.getElementById(target) : target;
        if (!element) return null;
        return AdminUiOffcanvas.instances.get(element) || null;
    }

    static initAll(root = document) {
        root.querySelectorAll('[data-rai-offcanvas]').forEach((element) => {
            if (!AdminUiOffcanvas.instances.has(element)) new AdminUiOffcanvas(element);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => AdminUiOffcanvas.initAll());
