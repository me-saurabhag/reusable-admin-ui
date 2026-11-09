/**
 * Defaults for the package API client.
 * Per-request options can override timeout, headers, credentials and routes.
 */
export default class Config {
    static ROUTES = Object.freeze({
        LOGIN: '/login',
        DASHBOARD: '/dashboard',
    });

    static REQUEST_TIMEOUT = 30000;

    static HEADERS = Object.freeze({
        ACCEPT: 'Accept',
        CONTENT_TYPE: 'Content-Type',
        CSRF_TOKEN: 'X-CSRF-TOKEN',
    });

    static CONTENT_TYPES = Object.freeze({
        JSON: 'application/json',
    });
}
