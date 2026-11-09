/**
 * Optional page foundation for pages that require browser geolocation.
 *
 * Keep BasePage lightweight: extend this class only on pages that need
 * location-aware behavior. Location is requested explicitly by calling
 * requireLocation() or requestLocation().
 */
import BasePage from './BasePage.js';
import LocationManager from './LocationManager.js';
import StatusDialog from '../dialogs/StatusDialog.js';

export default class LocationAwarePage extends BasePage {
    constructor(options = {}) {
        super(options);

        this.locationManager = LocationManager.getInstance();
        this.currentLocation = null;
        this.locationPromise = null;
        this.locationRequestPromise = null;
        this.lastLocationError = null;
    }

    /**
     * Request a fresh browser location.
     *
     * Concurrent calls on this page share the in-flight request. A successful
     * location is held on this page instance; call clearLocation() before a
     * later request when a new reading is required.
     */
    async requestLocation(options = {}) {
        if (this.locationRequestPromise) {
            return this.locationRequestPromise;
        }

        this.locationManager.clear();
        this.currentLocation = null;
        this.lastLocationError = null;

        this.locationRequestPromise = this.locationManager.requestLocation({
            enableHighAccuracy: true,
            timeout: 20000,
            maximumAge: 0,
            ...options,
        }).then((location) => {
            this.currentLocation = location;
            return location;
        }).catch((error) => {
            this.currentLocation = null;
            this.lastLocationError = error;
            return null;
        }).finally(() => {
            this.locationRequestPromise = null;
        });

        return this.locationRequestPromise;
    }

    /**
     * Require location and show the shared Location dialog if the request fails.
     * The dialog's OK button retries the request.
     */
    async requireLocation({
        title = 'Location Required',
        message = null,
        dialog = true,
        ...locationOptions
    } = {}) {
        const location = await this.requestLocation(locationOptions);

        if (location || !dialog) {
            return location;
        }

        StatusDialog.location({
            title,
            message: message ?? this.lastLocationError?.message
                ?? 'Please allow location access to continue.',
            isCancellable: false,
            onOk: () => {
                this.locationPromise = this.requireLocation({
                    title,
                    message,
                    dialog,
                    ...locationOptions,
                });
            },
        });

        return null;
    }

    getLocation() {
        return this.currentLocation;
    }

    hasLocation() {
        return this.currentLocation !== null;
    }

    getLocationAccuracy() {
        return this.currentLocation?.accuracy ?? null;
    }

    isLocationAccurate(maxAccuracy = 100) {
        return this.locationManager.isAccurate(maxAccuracy);
    }

    clearLocation() {
        this.locationManager.clear();
        this.currentLocation = null;
        this.locationPromise = null;
        this.lastLocationError = null;
    }
}
