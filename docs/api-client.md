# API Client

The package includes a small Fetch-based API client for browser-side requests. It is a utility only: the host application still owns endpoint URLs, authentication policy, authorization, validation rules, and business logic.

## Imports

```js
import ApiClient from '../vendor/admin-ui/core/api/ApiClient.js';
import ApiResponse from '../vendor/admin-ui/core/api/ApiResponse.js';
import Loader from '../vendor/admin-ui/core/Loader.js';
```

Adjust the relative import path to the location of your page module.

## Requests

```js
const response = await ApiClient.post('/api/login', {
    email: 'user@example.com',
    password: 'secret',
}, {
    showLoader: true,
});

if (response.isSuccess) {
    console.log(response.data);
} else {
    console.error(response.message);
}
```

Available methods: `get`, `post`, `put`, `patch`, `delete`, and `uploadImage`.

GET parameters are appended as query-string values. Objects are JSON-encoded and arrays are appended as repeated query parameters. `FormData` is sent as multipart data without manually setting its content type.

## Response contract

The normalizer preserves the application's response body:

```json
{
    "error": false,
    "errorCode": 200,
    "message": "Request completed",
    "data": {}
}
```

`ApiResponse` exposes `httpStatus`, `response`, `message`, `data`, `isSuccess`, `isOtp`, `isUnauthorized`, `hasError`, and `hasRedirect`.

Success and OTP are based on application error codes 200 and 201 respectively, and also require a successful 2xx HTTP status. Keep the host API response contract consistent with these values, or adapt the normalizer to the host's contract.

## Options

```js
const response = await ApiClient.get('/api/contacts', { page: 2 }, {
    showLoader: false,
    timeout: 15000,
    headers: { Authorization: `Bearer ${token}` },
    credentials: 'same-origin',
    redirectOnUnauthorized: false,
    signal: abortController.signal,
});
```

Options include `showLoader`, `loader`, `loaderTitle`, `loaderMessage`, `timeout`, `headers`, `credentials`, `redirect`, `cache`, `redirectOnUnauthorized`, `loginUrl`, and `signal`.

For same-origin requests the client automatically adds the Laravel CSRF token when a `meta[name="csrf-token"]` tag exists. Cross-origin requests do not receive that token automatically. A 401 response redirects to `Config.ROUTES.LOGIN` by default; disable that behavior per request with `redirectOnUnauthorized: false`.

The loader is optional per request and is not part of `BasePage`. Import only the services each page needs. Do not put tokens or endpoint-specific business rules into the package defaults.
