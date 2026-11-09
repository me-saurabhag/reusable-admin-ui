/**
 * Shared page loader. Uses a reference counter so overlapping requests do not
 * dismiss one another's loader prematurely.
 */
export default class Loader {
    static element = null;
    static counter = 0;
    static defaultTitle = 'Please Wait';
    static defaultMessage = 'Processing your request...';

    static show(title = null, message = null) {
        this.counter += 1;

        title ??= this.defaultTitle;
        message ??= this.defaultMessage;

        if (this.element?.isConnected) {
            this.update(title, message);
            return;
        }

        if (typeof document === 'undefined' || !document.body) return;

        document.body.style.overflow = 'hidden';

        const element = document.createElement('div');
        element.id = 'app-loader';
        element.innerHTML = `
            <div class="loader-overlay">
                <div class="loader-card">
                    <div class="loader-mofi">
                        <div class="loader-outter"></div>
                        <div class="loader-inner"></div>
                        <div class="loader-inner-1"></div>
                    </div>
                    <div class="loader-title"></div>
                    <div class="loader-message"></div>
                </div>
            </div>
        `;

        // Never interpolate caller-controlled text into innerHTML.
        element.querySelector('.loader-title').textContent = String(title);
        element.querySelector('.loader-message').textContent = String(message);

        this.element = element;
        document.body.appendChild(element);
    }

    static update(title = null, message = null) {
        if (!this.element) return;

        const titleElement = this.element.querySelector('.loader-title');
        const messageElement = this.element.querySelector('.loader-message');

        if (title !== null && titleElement) titleElement.textContent = String(title);
        if (message !== null && messageElement) messageElement.textContent = String(message);
    }

    static dismiss() {
        if (this.counter > 0) this.counter -= 1;
        if (this.counter !== 0 || !this.element) return;

        const element = this.element;
        this.element = null;

        if (typeof document !== 'undefined' && document.body) {
            document.body.style.overflow = '';
        }

        element.classList.add('loader-hide');
        window.setTimeout(() => element.remove(), 250);
    }

    static reset() {
        this.counter = 0;
        if (this.element) {
            this.element.remove();
            this.element = null;
        }
        if (typeof document !== 'undefined' && document.body) {
            document.body.style.overflow = '';
        }
    }
}
