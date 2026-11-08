/**
 * PinInput
 *
 * Accessible digit-by-digit PIN input behavior.
 * The component is presentation/input handling only; validation and PIN
 * verification remain the Host application's responsibility.
 */
export default class PinInput {
    constructor(container, options = {}) {
        this.container = typeof container === 'string'
            ? document.querySelector(container)
            : container;

        if (!this.container) {
            throw new Error('PinInput: a valid container element is required.');
        }

        this.inputs = [...this.container.querySelectorAll('.pin-box')];
        this.valueInput = this.container.querySelector('[data-pin-value]');
        this.abort = new AbortController();

        if (!this.inputs.length) {
            throw new Error('PinInput: no .pin-box inputs were found in the container.');
        }

        const masked = options.masked ?? this.container.dataset.pinMasked !== 'false';

        this.inputs.forEach((input, index) => {
            input.maxLength = 1;
            input.inputMode = 'numeric';
            input.autocomplete = 'off';
            input.type = masked ? 'password' : 'text';
            input.dataset.pinIndex = String(index);
        });

        this.bind();
        this.syncValue();
    }

    bind() {
        const opts = { signal: this.abort.signal };

        this.inputs.forEach((input, index) => {
            input.addEventListener('input', (event) => this.handleInput(event, index), opts);
            input.addEventListener('keydown', (event) => this.handleKeydown(event, index), opts);
            input.addEventListener('paste', (event) => this.handlePaste(event), opts);
        });
    }

    handleInput(event, index) {
        const input = event.currentTarget;
        const digits = input.value.replace(/\D/g, '');

        if (digits.length > 1) {
            this.setDigits(digits);
            return;
        }

        input.value = digits.slice(0, 1);
        this.syncValue();

        if (input.value && index < this.inputs.length - 1) {
            this.inputs[index + 1].focus();
        }

        this.container.dispatchEvent(new CustomEvent('rai:pin-input', {
            bubbles: true,
            detail: { value: this.getValue(), complete: this.isComplete() },
        }));
    }

    handleKeydown(event, index) {
        const input = this.inputs[index];

        if (event.key === 'Backspace') {
            if (input.value) {
                input.value = '';
            } else if (index > 0) {
                this.inputs[index - 1].value = '';
                this.inputs[index - 1].focus();
            }

            this.syncValue();
            event.preventDefault();
            return;
        }

        if (event.key === 'ArrowLeft' && index > 0) {
            this.inputs[index - 1].focus();
            event.preventDefault();
        } else if (event.key === 'ArrowRight' && index < this.inputs.length - 1) {
            this.inputs[index + 1].focus();
            event.preventDefault();
        }
    }

    handlePaste(event) {
        event.preventDefault();

        const clipboard = event.clipboardData ?? window.clipboardData;
        const digits = clipboard?.getData('text')?.replace(/\D/g, '') ?? '';

        if (!digits) return;

        this.setDigits(digits);
    }

    setDigits(value) {
        const digits = String(value ?? '').replace(/\D/g, '').slice(0, this.inputs.length);

        this.inputs.forEach((input, index) => {
            input.value = digits[index] ?? '';
        });

        this.syncValue();

        const nextEmpty = this.inputs.find(input => !input.value);
        (nextEmpty ?? this.inputs[this.inputs.length - 1]).focus();

        this.container.dispatchEvent(new CustomEvent('rai:pin-input', {
            bubbles: true,
            detail: { value: this.getValue(), complete: this.isComplete() },
        }));
    }

    getValue() {
        return this.inputs.map(input => input.value).join('');
    }

    isComplete() {
        return this.getValue().length === this.inputs.length;
    }

    syncValue() {
        if (this.valueInput) {
            this.valueInput.value = this.getValue();
            this.valueInput.dispatchEvent(new Event('input', { bubbles: true }));
        }
    }

    clear({ focus = true } = {}) {
        this.inputs.forEach(input => { input.value = ''; });
        this.syncValue();

        if (focus) this.inputs[0]?.focus();
    }

    focus() {
        this.inputs[0]?.focus();
    }

    destroy() {
        this.abort.abort();
    }
}

if (typeof window !== 'undefined') {
    window.PinInput ??= PinInput;
}
