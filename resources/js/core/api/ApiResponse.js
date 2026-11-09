import ApiResponseBody from './ApiResponseBody.js';

/** HTTP status plus the normalized application response body. */
export default class ApiResponse {
    constructor(httpStatus = 0, response = new ApiResponseBody()) {
        this.httpStatus = Number(httpStatus) || 0;
        this.response = response instanceof ApiResponseBody
            ? response
            : new ApiResponseBody(response);
    }

    get isSuccess() {
        return this.httpStatus >= 200
            && this.httpStatus < 300
            && this.response.errorCode === 200
            && !this.response.error;
    }

    get isOtp() {
        return this.httpStatus >= 200
            && this.httpStatus < 300
            && this.response.errorCode === 201
            && !this.response.error;
    }

    get isUnauthorized() {
        return this.httpStatus === 401;
    }

    get hasError() {
        return this.response.error || this.httpStatus >= 400 || this.httpStatus === 0;
    }

    get hasRedirect() {
        return this.httpStatus === 302;
    }

    get message() {
        return this.response.message;
    }

    get data() {
        return this.response.data;
    }
}
