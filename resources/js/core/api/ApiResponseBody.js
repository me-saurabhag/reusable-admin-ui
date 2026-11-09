/**
 * Normalized application response body.
 *
 * Expected application contract:
 * { error: boolean, errorCode: number, message: string, data: any }
 */
export default class ApiResponseBody {
    constructor(payload = {}) {
        const source = payload && typeof payload === 'object' && !Array.isArray(payload)
            ? payload
            : {};

        this.error = Boolean(source.error ?? false);
        this.errorCode = Number(source.errorCode ?? 400);
        this.message = String(source.message ?? '');
        this.data = source.data ?? null;
    }
}
