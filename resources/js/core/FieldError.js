/**
 * Field-level validation feedback for native HTML and server-side errors.
 *
 * Usage:
 *   FieldError.bind(form);
 *   FieldError.validate(form);
 *   FieldError.show(field, 'This field is required.');
 *   FieldError.showServerErrors(form, response.errors);
 */
export default class FieldError {
    static tooltip = null;
    static visibleFor = null;
    static bindings = new WeakMap();
    static positionHandler = null;

    static ensureTooltip() {
        if (this.tooltip?.isConnected) return this.tooltip;
        if (typeof document === 'undefined' || !document.body) return null;

        const tooltip = document.createElement('div');
        tooltip.className = 'rai-field-error-tooltip';
        tooltip.setAttribute('role', 'alert');
        tooltip.setAttribute('aria-live', 'assertive');
        tooltip.hidden = true;

        document.body.appendChild(tooltip);
        this.tooltip = tooltip;

        if (!this.positionHandler) {
            this.positionHandler = () => {
                if (this.visibleFor?.isConnected && this.tooltip && !this.tooltip.hidden) {
                    this.position(this.visibleFor, this.tooltip);
                }
            };

            window.addEventListener('resize', this.positionHandler);
            window.addEventListener('scroll', this.positionHandler, true);
        }

        return tooltip;
    }

    static position(field, tooltip) {
        const rect = field.getBoundingClientRect();
        const margin = 8;

        tooltip.style.left = '8px';
        tooltip.style.top = '8px';

        const tipRect = tooltip.getBoundingClientRect();
        const fitsAbove = rect.top >= tipRect.height + margin + 8;
        const placement = fitsAbove ? 'top' : 'bottom';

        let top = fitsAbove
            ? rect.top - tipRect.height - margin
            : rect.bottom + margin;

        let left = rect.left;

        if (left + tipRect.width > window.innerWidth - 8) {
            left = window.innerWidth - tipRect.width - 8;
        }

        left = Math.max(8, left);
        top = Math.max(8, Math.min(top, window.innerHeight - tipRect.height - 8));

        tooltip.dataset.placement = placement;
        tooltip.style.left = `${Math.round(left)}px`;
        tooltip.style.top = `${Math.round(top)}px`;
    }

    static show(field, message) {
        if (!field || typeof document === 'undefined') return false;

        const text = String(message ?? '').trim();
        if (!text) return false;

        const tooltip = this.ensureTooltip();
        if (!tooltip) return false;

        if (this.visibleFor && this.visibleFor !== field) {
            const previousDescriptions = (this.visibleFor.getAttribute('aria-describedby') ?? '')
                .split(/\\s+/)
                .filter(id => id && id !== 'rai-field-error-tooltip');

            if (previousDescriptions.length) {
                this.visibleFor.setAttribute('aria-describedby', previousDescriptions.join(' '));
            } else {
                this.visibleFor.removeAttribute('aria-describedby');
            }
        }

        field.setCustomValidity(text);
        field.classList.add('field-error');
        field.setAttribute('aria-invalid', 'true');

        const describedBy = new Set(
            (field.getAttribute('aria-describedby') ?? '')
                .split(/\s+/)
                .filter(Boolean)
        );

        describedBy.add(tooltip.id || 'rai-field-error-tooltip');
        tooltip.id = 'rai-field-error-tooltip';
        field.setAttribute('aria-describedby', Array.from(describedBy).join(' '));

        tooltip.textContent = text;
        tooltip.hidden = false;
        tooltip.classList.add('is-visible');

        this.visibleFor = field;
        this.position(field, tooltip);

        if (!this.bindings.has(field)) {
            const clearOnEdit = () => this.clear(field);
            field.addEventListener('input', clearOnEdit);
            field.addEventListener('change', clearOnEdit);
            this.bindings.set(field, clearOnEdit);
        }

        return true;
    }

    static clear(field) {
        if (!field) return;

        field.setCustomValidity('');
        field.classList.remove('field-error');
        field.removeAttribute('aria-invalid');

        const tooltipId = this.tooltip?.id || 'rai-field-error-tooltip';
        const describedBy = (field.getAttribute('aria-describedby') ?? '')
            .split(/\s+/)
            .filter(id => id && id !== tooltipId);

        if (describedBy.length) {
            field.setAttribute('aria-describedby', describedBy.join(' '));
        } else {
            field.removeAttribute('aria-describedby');
        }

        const handler = this.bindings.get(field);
        if (handler) {
            field.removeEventListener('input', handler);
            field.removeEventListener('change', handler);
            this.bindings.delete(field);
        }

        if (this.visibleFor === field) {
            this.hideTooltip();
            this.visibleFor = null;
        }
    }

    static hideTooltip() {
        if (!this.tooltip) return;
        this.tooltip.classList.remove('is-visible');
        this.tooltip.hidden = true;
        this.tooltip.textContent = '';
    }

    static clearAll(container = document) {
        if (!container?.querySelectorAll) return;
        container.querySelectorAll('input, select, textarea').forEach(field => this.clear(field));
    }

    /**
     * Bind native HTML validation events to the custom tooltip.
     * The browser's built-in validation rules remain authoritative.
     */
    static bind(form) {
        if (!form?.elements) return () => {};

        const onInvalid = event => {
            const field = event.target;
            if (!field?.willValidate || !field.validity || field.validity.valid) return;

            event.preventDefault();

            // Keep one tooltip visible: show the first invalid control only.
            if (!this.visibleFor || !this.visibleFor.isConnected) {
                this.show(field, field.validationMessage || 'Please check this field.');
            }
        };

        const onEdit = event => {
            if (event.target?.matches?.('input, select, textarea')) {
                this.clear(event.target);
            }
        };

        const previousNoValidate = form.noValidate;
        form.noValidate = true;

        form.addEventListener('invalid', onInvalid, true);
        form.addEventListener('input', onEdit, true);
        form.addEventListener('change', onEdit, true);

        const cleanup = () => {
            form.removeEventListener('invalid', onInvalid, true);
            form.removeEventListener('input', onEdit, true);
            form.removeEventListener('change', onEdit, true);
            form.noValidate = previousNoValidate;
            this.clearAll(form);
        };

        return cleanup;
    }

    /** Validate a form and display/focus its first invalid control. */
    static validate(form, { focus = true } = {}) {
        if (!form?.elements) return false;

        const valid = form.checkValidity();
        if (valid) return true;

        const firstInvalid = Array.from(form.elements).find(field =>
            field.willValidate && !field.validity.valid
        );

        if (firstInvalid) {
            this.show(
                firstInvalid,
                firstInvalid.validationMessage || 'Please check this field.'
            );

            if (focus) firstInvalid.focus({ preventScroll: false });
        }

        return false;
    }

    /** Display Laravel/API validation errors using input name attributes. */
    static showServerErrors(form, errors = {}) {
        if (!form?.elements || !errors || typeof errors !== 'object') return 0;

        let count = 0;
        let firstInvalid = null;

        Object.entries(errors).forEach(([name, messages]) => {
            const field = form.elements.namedItem(name);
            if (!field) return;

            const target = typeof RadioNodeList !== 'undefined' && field instanceof RadioNodeList
                ? field[0]
                : field;

            const message = Array.isArray(messages) ? messages[0] : messages;
            if (!target || !message) return;

            target.setCustomValidity(String(message));
            target.classList.add('field-error');
            target.setAttribute('aria-invalid', 'true');

            if (!this.bindings.has(target)) {
                const clearOnEdit = () => this.clear(target);
                target.addEventListener('input', clearOnEdit);
                target.addEventListener('change', clearOnEdit);
                this.bindings.set(target, clearOnEdit);
            }

            if (!firstInvalid) firstInvalid = { field: target, message };
            count++;
        });

        if (firstInvalid) {
            this.show(firstInvalid.field, firstInvalid.message);
            firstInvalid.field.focus?.({ preventScroll: false });
        }

        return count;
    }
}
