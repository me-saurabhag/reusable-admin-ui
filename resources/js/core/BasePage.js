import LocationManager from './LocationManager.js';
import StatusDialog from '../dialogs/StatusDialog.js';

/**
 * BasePage
 *
 * Shared foundation for pages built with Reusable Admin UI. It provides a
 * common DOM root, event lifecycle, header/profile action hooks, optional
 * Toast/Loader integration, and access to the shared LocationManager.
 *
 * The host application remains responsible for page-specific business logic,
 * API calls, validation, authentication, navigation, and persistence.
 */
export default class BasePage {
    constructor({ root = null, toast = null, loader = null } = {}) {
        this.root = root ?? (typeof document !== 'undefined' ? document : null);
        this.toast = toast
            ?? (typeof window !== 'undefined' ? (window.AdminUiToast ?? null) : null);
        this.loader = loader
            ?? (typeof window !== 'undefined' ? (window.AdminUiLoader ?? null) : null);

        this.locationManager = LocationManager.getInstance();
        this.statusDialog = StatusDialog;
        this.abortController = new AbortController();

        this.handleHeaderAction = this.handleHeaderAction.bind(this);
        this.handleProfileAction = this.handleProfileAction.bind(this);

        this.registerGlobalEvents();
    }

    /** Base initialization hook. Child classes should call super.init(). */
    init() {
        return true;
    }

    /** Register framework events using this page's disposable lifecycle. */
    registerGlobalEvents() {
        if (typeof document === 'undefined') return;

        document.addEventListener('admin-ui:header-action', this.handleHeaderAction, {
            signal: this.abortController.signal,
        });

        document.addEventListener('admin-ui:profile-action', this.handleProfileAction, {
            signal: this.abortController.signal,
        });
    }

    /**
     * Add a listener that is automatically removed by destroy().
     * The BasePage lifecycle signal owns the listener lifetime.
     */
    on(target, eventName, callback, options = {}) {
        if (!target?.addEventListener || typeof callback !== 'function') {
            return false;
        }

        target.addEventListener(eventName, callback, {
            ...options,
            signal: this.abortController.signal,
        });

        return true;
    }

    /** Set or change the DOM root used by query() and queryAll(). */
    setRoot(root) {
        if (root?.querySelector) {
            this.root = root;
        }

        return this;
    }

    /** Query one element inside this page's root. */
    query(selector) {
        return this.root?.querySelector(selector) ?? null;
    }

    /** Query all matching elements inside this page's root. */
    queryAll(selector) {
        return this.root?.querySelectorAll(selector) ?? [];
    }

    /**
     * Request browser location only when a page explicitly needs it.
     * This method intentionally does not run from init().
     */
    async requestLocation({ showError = true, ...options } = {}) {
        try {
            return await this.locationManager.requestLocation(options);
        } catch (error) {
            console.error('BasePage: location request failed.', error);

            if (showError) {
                this.toast?.error?.(
                    error?.message ?? 'Unable to get your location.'
                );
            }

            return null;
        }
    }

    /** Return the last successfully obtained browser location, or null. */
    getLocation() {
        return this.locationManager.getLocation();
    }

    /** Check whether a browser location is currently cached. */
    hasLocation() {
        return this.locationManager.hasLocation();
    }

    /** Return browser-reported location accuracy in meters, or null. */
    getLocationAccuracy() {
        return this.locationManager.getAccuracy();
    }

    /** Informational accuracy check only; never use for authorization. */
    isLocationAccurate(maxAccuracy = 100) {
        return this.locationManager.isAccurate(maxAccuracy);
    }

    /** Clear the shared location cache and invalidate an in-flight request. */
    clearLocation() {
        this.locationManager.clear();
    }

    /** Inject the host application's Toast utility. */
    setToast(toast) {
        this.toast = toast ?? null;
        return this;
    }

    /** Inject the host application's optional Loader utility. */
    setLoader(loader) {
        this.loader = loader ?? null;
        return this;
    }

    /** Framework event entry point; override onHeaderAction() in a child. */
    handleHeaderAction(event) {
        const action = event?.detail?.action;
        if (action) this.onHeaderAction(action, event);
    }

    /** Framework event entry point; override onProfileAction() in a child. */
    handleProfileAction(event) {
        const action = event?.detail?.action;
        if (action) this.onProfileAction(action, event);
    }

    /** Override in a child page to handle header actions. */
    onHeaderAction(action, event) {
        // Intentionally empty. Business/navigation behavior belongs to the host.
    }

    /** Override in a child page to handle profile actions. */
    onProfileAction(action, event) {
        // Intentionally empty. Business/navigation behavior belongs to the host.
    }

    /** Convert action keys such as `quick_create` into `Quick Create`. */
    toLabel(value) {
        return String(value ?? '')
            .replace(/[_-]+/g, ' ')
            .replace(/\b\w/g, character => character.toUpperCase());
    }

    /** Remove listeners owned by this page instance. */
    destroy() {
        if (!this.abortController.signal.aborted) {
            this.abortController.abort();
        }
    }
}
