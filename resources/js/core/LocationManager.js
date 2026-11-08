/**
 * LocationManager
 *
 * Shared browser-geolocation service for package pages.
 * Location requests are always explicit; never request location automatically
 * while a page is initializing.
 *
 * IMPORTANT: Browser geolocation is suitable for normal UI functionality
 * only. It is not authoritative proof of location for AEPS geofencing or any
 * other security-sensitive authorization.
 */
class LocationManager {
    static instance = null;

    static getInstance() {
        if (!LocationManager.instance) {
            LocationManager.instance = new LocationManager();
        }

        return LocationManager.instance;
    }

    constructor() {
        // Keep the service singleton even if a consumer calls `new` directly.
        if (LocationManager.instance) {
            return LocationManager.instance;
        }

        LocationManager.instance = this;
        this.location = null;
        this.initialized = false;
        this.initializationPromise = null;
        this.requestId = 0;
    }

    /**
     * Request the current browser location.
     * Concurrent calls share one request. Successful results are cached until
     * clear() is called.
     *
     * @param {Object} options
     * @param {boolean} options.enableHighAccuracy
     * @param {number} options.timeout Maximum wait time in milliseconds.
     * @param {number} options.maximumAge Maximum acceptable cached position age.
     * @returns {Promise<Object>}
     */
    start({
        enableHighAccuracy = true,
        timeout = 20000,
        maximumAge = 0,
    } = {}) {
        if (this.initialized && this.location) {
            return Promise.resolve(this.location);
        }

        if (this.initializationPromise) {
            return this.initializationPromise;
        }

        if (typeof navigator === 'undefined' || !navigator.geolocation) {
            return Promise.reject(this.createError(
                'unsupported',
                'Location is not supported by this browser or is unavailable in this context.'
            ));
        }

        const requestId = ++this.requestId;
        const requestPromise = new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    if (requestId !== this.requestId) {
                        reject(this.createError(
                            'request_cancelled',
                            'The location request was cancelled. Please try again.'
                        ));
                        return;
                    }

                    const coords = position.coords;

                    this.location = {
                        latitude: coords.latitude,
                        longitude: coords.longitude,
                        accuracy: coords.accuracy,
                        altitude: coords.altitude,
                        altitudeAccuracy: coords.altitudeAccuracy,
                        heading: coords.heading,
                        speed: coords.speed,
                        timestamp: position.timestamp,
                    };

                    this.initialized = true;
                    this.initializationPromise = null;
                    resolve(this.location);
                },
                (error) => {
                    if (requestId !== this.requestId) {
                        reject(this.createError(
                            'request_cancelled',
                            'The location request was cancelled. Please try again.'
                        ));
                        return;
                    }

                    this.initializationPromise = null;
                    reject(this.normalizeError(error));
                },
                { enableHighAccuracy, timeout, maximumAge }
            );
        });

        this.initializationPromise = requestPromise;

        return requestPromise;
    }

    /** Descriptive alias for start(). */
    requestLocation(options = {}) {
        return this.start(options);
    }

    /** Return the last successful location, or null. */
    getLocation() {
        return this.location;
    }

    /** Check whether a location has been obtained successfully. */
    hasLocation() {
        return this.location !== null;
    }

    /** Return browser-reported accuracy in meters, or null. */
    getAccuracy() {
        return this.location?.accuracy ?? null;
    }

    /**
     * Informational accuracy check only; never use it for authorization.
     * @param {number} maxAccuracy Maximum accepted accuracy in meters.
     */
    isAccurate(maxAccuracy = 100) {
        if (
            !this.location ||
            typeof this.location.accuracy !== 'number' ||
            !Number.isFinite(this.location.accuracy) ||
            typeof maxAccuracy !== 'number' ||
            !Number.isFinite(maxAccuracy) ||
            maxAccuracy < 0
        ) {
            return false;
        }

        return this.location.accuracy <= maxAccuracy;
    }

    /**
     * Clear cached location and invalidate any request in flight.
     * The browser's geolocation prompt itself cannot be forcibly cancelled.
     */
    clear() {
        this.requestId++;
        this.location = null;
        this.initialized = false;
        this.initializationPromise = null;
    }

    /** Convert browser geolocation errors into predictable application errors. */
    normalizeError(error) {
        switch (error?.code) {
            case 1:
                return this.createError(
                    'permission_denied',
                    'Location permission was denied. Please allow location access in your browser settings.'
                );
            case 2:
                return this.createError(
                    'position_unavailable',
                    'Your current location is unavailable. Please try again.'
                );
            case 3:
                return this.createError(
                    'timeout',
                    'The location request timed out. Please try again.'
                );
            default:
                return this.createError(
                    'unknown',
                    'Unable to determine your location. Please try again.'
                );
        }
    }

    /** Create an Error with a stable machine-readable code. */
    createError(code, message) {
        const error = new Error(message);
        error.code = code;
        return error;
    }
}

export default LocationManager;
