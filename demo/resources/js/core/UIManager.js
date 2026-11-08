class UIManager {
    static container = null;
    static activeToasts = new Map();

    static TYPES = {
        success: {
            icon: 'check-circle',
            svg: '<circle cx="12" cy="12" r="9"></circle><path d="m8 12 2.5 2.5L16.5 9"></path>',
            title: 'Success',
            class: 'toast-success',
        },
        danger: {
            icon: 'x-circle',
            svg: '<circle cx="12" cy="12" r="9"></circle><path d="m9 9 6 6m0-6-6 6"></path>',
            title: 'Error',
            class: 'toast-danger',
        },
        warning: {
            icon: 'alert-triangle',
            svg: '<path d="m10.3 3.9-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.7-3.1l-8-14a2 2 0 0 0-3.4 0Z"></path><path d="M12 9v4m0 4h.01"></path>',
            title: 'Warning',
            class: 'toast-warning',
        },
        info: {
            icon: 'info',
            svg: '<circle cx="12" cy="12" r="9"></circle><path d="M12 11v5m0-8h.01"></path>',
            title: 'Information',
            class: 'toast-info',
        },
    };

    static success(message, title = 'Congratulation !', delay = 4000) {
        return this.toast(message, title, 'success', delay);
    }

    static error(message, title = 'Error', delay = 5000) {
        return this.toast(message, title, 'danger', delay);
    }

    static warning(message, title = 'Warning', delay = 5000) {
        return this.toast(message, title, 'warning', delay);
    }

    static info(message, title = null, delay = 4000) {
        return this.toast(message, title, 'info', delay);
    }

    static toast(message, title = null, type = 'success', delay = 4000) {
        const config = this.TYPES[type] ?? this.TYPES.info;
        const container = this.createContainer();
        const id = `toast-${Date.now()}-${Math.floor(Math.random() * 10000)}`;
        const element = document.createElement('div');

        element.id = id;
        element.className = `toast app-toast ${config.class}`;
        element.setAttribute('role', 'alert');
        element.setAttribute('aria-live', 'assertive');
        element.setAttribute('aria-atomic', 'true');

        const header = document.createElement('div');
        header.className = 'toast-header';

        const icon = document.createElement('div');
        icon.className = 'toast-icon';
        const iconElement = document.createElement('i');
        iconElement.setAttribute('data-feather', config.icon);
        iconElement.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">${config.svg}</svg>`;
        icon.appendChild(iconElement);

        const headerContent = document.createElement('div');
        headerContent.className = 'toast-header-content';
        const titleElement = document.createElement('div');
        titleElement.className = 'toast-title';
        titleElement.textContent = title ?? config.title;
        headerContent.appendChild(titleElement);

        const closeButton = document.createElement('button');
        closeButton.type = 'button';
        closeButton.className = 'btn-close';
        closeButton.setAttribute('aria-label', 'Close');
        closeButton.setAttribute('data-bs-dismiss', 'toast');

        header.append(icon, headerContent, closeButton);

        const body = document.createElement('div');
        body.className = 'toast-body';
        body.textContent = message == null ? '' : String(message);

        const progress = document.createElement('div');
        progress.className = 'toast-progress';
        const progressBar = document.createElement('div');
        progressBar.className = 'toast-progress-bar';
        progressBar.style.animationDuration = `${Math.max(0, delay)}ms`;
        progress.appendChild(progressBar);

        element.append(header, body, progress);
        container.appendChild(element);

        if (typeof window.feather?.replace === 'function') {
            window.feather.replace({ width: 14, height: 14 });
        }

        if (!window.bootstrap?.Toast) {
            const record = {
                element,
                instance: null,
                timer: null,
                startedAt: 0,
                remaining: Math.max(0, Number(delay) || 0),
                progressBar,
            };

            const removeToast = () => {
                if (record.timer !== null) window.clearTimeout(record.timer);
                element.classList.add('toast-hide');
                this.activeToasts.delete(id);
                window.setTimeout(() => element.remove(), 250);
            };

            const startTimer = () => {
                if (record.timer !== null) return;
                if (record.remaining <= 0) {
                    removeToast();
                    return;
                }

                record.startedAt = Date.now();
                record.timer = window.setTimeout(removeToast, record.remaining);
                progressBar.style.animationPlayState = 'running';
            };

            const pauseTimer = () => {
                if (record.timer === null) return;

                window.clearTimeout(record.timer);
                record.timer = null;
                record.remaining = Math.max(0, record.remaining - (Date.now() - record.startedAt));
                progressBar.style.animationPlayState = 'paused';
            };

            closeButton.addEventListener('click', removeToast);
            element.addEventListener('mouseenter', pauseTimer);
            element.addEventListener('mouseleave', startTimer);
            this.activeToasts.set(id, record);
            element.classList.add('show');
            startTimer();
            return null;
        }

        const toast = new window.bootstrap.Toast(element, {
            autohide: false,
            animation: true,
        });

        const record = {
            element,
            instance: toast,
            timer: null,
            startedAt: 0,
            remaining: Math.max(0, Number(delay) || 0),
            progressBar,
        };

        const startTimer = () => {
            if (record.timer !== null) return;
            if (record.remaining <= 0) {
                toast.hide();
                return;
            }

            record.startedAt = Date.now();
            record.timer = window.setTimeout(() => toast.hide(), record.remaining);
            progressBar.style.animationPlayState = 'running';
        };

        const pauseTimer = () => {
            if (record.timer === null) return;

            window.clearTimeout(record.timer);
            record.timer = null;
            record.remaining = Math.max(0, record.remaining - (Date.now() - record.startedAt));
            progressBar.style.animationPlayState = 'paused';
        };

        closeButton.addEventListener('click', () => toast.hide());
        element.addEventListener('mouseenter', pauseTimer);
        element.addEventListener('mouseleave', startTimer);
        element.addEventListener('hidden.bs.toast', () => {
            if (record.timer !== null) window.clearTimeout(record.timer);
            this.activeToasts.delete(id);
            element.classList.add('toast-hide');
            window.setTimeout(() => element.remove(), 250);
        }, { once: true });

        this.activeToasts.set(id, record);
        toast.show();
        startTimer();

        return toast;
    }

    static createContainer() {
        if (this.container?.isConnected) return this.container;

        this.container = document.getElementById('app-toast-container');

        if (!this.container) {
            this.container = document.createElement('div');
            this.container.id = 'app-toast-container';
            this.container.className = 'toast-container position-fixed top-0 end-0 p-3';
            this.container.setAttribute('aria-live', 'polite');
            this.container.setAttribute('aria-atomic', 'true');
            document.body.appendChild(this.container);
        }

        return this.container;
    }

    static clear() {
        for (const [id, record] of this.activeToasts) {
            if (record.timer !== null) window.clearTimeout(record.timer);
            record.instance?.dispose();
            record.element.remove();
            this.activeToasts.delete(id);
        }

        if (this.container) this.container.innerHTML = '';
    }
}

export default UIManager;
