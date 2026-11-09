import Config from './Config.js';
import Loader from '../Loader.js';
import ApiResponse from './ApiResponse.js';
import ApiResponseBody from './ApiResponseBody.js';

/**
 * Fetch-based API client for Laravel and JSON endpoints.
 *
 * Static methods keep usage simple; each call can override headers, timeout,
 * loader behavior, credentials and unauthorized redirect behavior.
 */
export default class ApiClient {
    static get(url, params = {}, options = {}) {
        return this.#request('GET', url, params, options);
    }

    static post(url, data = {}, options = {}) {
        return this.#request('POST', url, data, options);
    }

    static put(url, data = {}, options = {}) {
        return this.#request('PUT', url, data, options);
    }

    static patch(url, data = {}, options = {}) {
        return this.#request('PATCH', url, data, options);
    }

    static delete(url, data = {}, options = {}) {
        return this.#request('DELETE', url, data, options);
    }

    static uploadImage(url, fileType, file, options = {}) {
        const formData = new FormData();
        formData.append('fileType', fileType);
        formData.append('file', file);
        return this.post(url, formData, options);
    }

    static async #request(method, url, data = null, options = {}) {
        const controller = new AbortController();
        const timeoutMs = Number(options.timeout ?? Config.REQUEST_TIMEOUT);
        const timeout = window.setTimeout(() => controller.abort(), timeoutMs);
        const externalSignal = options.signal;
        const abortFromExternal = () => controller.abort();

        if (externalSignal) {
            if (externalSignal.aborted) controller.abort();
            else externalSignal.addEventListener('abort', abortFromExternal, { once: true });
        }

        const headers = {
            [Config.HEADERS.ACCEPT]: Config.CONTENT_TYPES.JSON,
            'X-Requested-With': 'XMLHttpRequest',
            ...(options.headers ?? {}),
        };

        let requestUrl = url;
        let body = null;

        try {
            const parsedUrl = new URL(url, window.location.origin);
            const isSameOrigin = parsedUrl.origin === window.location.origin;

            if (method === 'GET' && data && Object.keys(data).length > 0) {
                Object.entries(data).forEach(([key, value]) => {
                    if (value === undefined || value === null) return;
                    if (Array.isArray(value)) {
                        value.forEach(item => parsedUrl.searchParams.append(key, String(item)));
                    } else if (typeof value === 'object') {
                        parsedUrl.searchParams.set(key, JSON.stringify(value));
                    } else {
                        parsedUrl.searchParams.set(key, String(value));
                    }
                });
                requestUrl = parsedUrl.toString();
            }

            if (method !== 'GET' && data !== null && data !== undefined) {
                if (data instanceof FormData || data instanceof Blob) {
                    body = data;
                    // The browser must generate the multipart boundary for FormData.
                } else if (typeof data === 'string') {
                    body = data;
                    headers[Config.HEADERS.CONTENT_TYPE] ??= 'text/plain;charset=UTF-8';
                } else {
                    headers[Config.HEADERS.CONTENT_TYPE] ??= Config.CONTENT_TYPES.JSON;
                    body = JSON.stringify(data);
                }
            }

            if (isSameOrigin) {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (csrf && !headers[Config.HEADERS.CSRF_TOKEN]) {
                    headers[Config.HEADERS.CSRF_TOKEN] = csrf;
                }
            }

            if (options.showLoader !== false) {
                (options.loader ?? Loader).show(options.loaderTitle, options.loaderMessage);
            }

            const response = await fetch(requestUrl, {
                method,
                headers,
                body,
                credentials: options.credentials ?? 'same-origin',
                signal: controller.signal,
                redirect: options.redirect ?? 'follow',
                cache: options.cache,
            });

            if (response.status === 401 && options.redirectOnUnauthorized !== false) {
                return this.#handleUnauthorized(options.loginUrl);
            }

            if (response.redirected || response.type === 'opaqueredirect' || response.status === 302) {
                const redirectUrl = response.url || response.headers.get('Location') || Config.ROUTES.DASHBOARD;
                return new ApiResponse(302, new ApiResponseBody({
                    error: false,
                    errorCode: 302,
                    message: 'Redirect',
                    data: { url: redirectUrl },
                }));
            }

            let responseBody;
            const contentType = response.headers.get('content-type') ?? '';

            if (response.status === 204 || response.status === 205) {
                responseBody = { error: false, errorCode: response.status, message: 'Request completed.', data: null };
            } else if (contentType.includes('application/json') || contentType.includes('+json')) {
                try {
                    responseBody = await response.json();
                } catch {
                    responseBody = { error: true, errorCode: response.status, message: 'Invalid JSON response.', data: null };
                }
            } else {
                const text = await response.text();
                responseBody = {
                    error: !response.ok,
                    errorCode: response.status,
                    message: text || (response.ok ? 'Request completed.' : response.statusText),
                    data: null,
                };
            }

            const normalized = new ApiResponseBody(responseBody);
            if (!response.ok && !normalized.error) normalized.error = true;
            if (!normalized.errorCode) normalized.errorCode = response.status;

            return new ApiResponse(response.status, normalized);
        } catch (error) {
            if (error?.name === 'AbortError') {
                return new ApiResponse(0, new ApiResponseBody({
                    error: true,
                    errorCode: 408,
                    message: externalSignal?.aborted ? 'Request cancelled.' : 'Request timeout.',
                }));
            }

            return new ApiResponse(0, new ApiResponseBody({
                error: true,
                errorCode: 0,
                message: 'Unable to connect to server.',
            }));
        } finally {
            window.clearTimeout(timeout);
            externalSignal?.removeEventListener('abort', abortFromExternal);
            if (options.showLoader !== false) (options.loader ?? Loader).dismiss();
        }
    }

    static #handleUnauthorized(loginUrl = Config.ROUTES.LOGIN) {
        if (loginUrl) window.location.replace(loginUrl);

        return new ApiResponse(401, new ApiResponseBody({
            error: true,
            errorCode: 401,
            message: 'Your session has expired. Please login again.',
        }));
    }
}
