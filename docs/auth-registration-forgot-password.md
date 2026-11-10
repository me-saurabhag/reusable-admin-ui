# Registration and Forgot Password UI

The package provides three registration visual variants (`v1`, `v2`, `v3`) and one centered password-reset form. It registers GET page routes only. The host application owns POST routes, validation, OTP/email verification, password policy, API calls and redirects.

## Host JavaScript integration

`RegisterPage.js` dispatches cancelable `admin-ui:register-submit`; `ForgotPasswordPage.js` dispatches `admin-ui:forgot-password-submit`. The host listener must call `event.preventDefault()` synchronously before any `await` when it handles submission using fetch/AJAX. `event.detail.formData` contains the submitted fields. Registration also includes `event.detail.request`, a normalized object with `fullName`, `email`, `mobile`, `refCode`, `countryCode`, `regionCode`, and `geoLocation`. Calling codes are sent without `+` (for example, `91`), while the country region is sent separately (for example, `IN`).

## Request browser location only when needed

Location permission is opt-in. In a page class extending `BasePage`, call this from the appropriate user flow (preferably after an explicit user action):

```js
const location = await this.requestLocation();
if (!location) return; // user denied, unavailable, or timed out

const { latitude, longitude, accuracy } = location;
// Send only if the host application's business flow actually needs it.
```

`requestLocation()` uses the browser Geolocation API. It requires HTTPS (localhost is generally allowed), browser permission and user consent. Do not request location simply because a user opens Login/Register/Forgot Password. Do not treat browser coordinates as authoritative identity, address or geofence proof.

## Configuration

- `admin-ui.auth.registration.variant`: `v1`, `v2` or `v3`.
- `admin-ui.auth.registration.route`: GET route configuration.
- `admin-ui.auth.registration.action`: host POST endpoint.
- `admin-ui.auth.registration.fields`: names, labels, placeholders and enabled/required flags.
- `admin-ui.auth.forgot_password`: centered form text, field names, GET route and host POST action.

The password-reset page displays Email, New Password and Re-Type Password as requested. A production host should only accept this form after a valid reset token or other verified recovery step; never allow an email alone to authorize changing a password.


## Registration country selector

Configure the available countries in `admin-ui.auth.registration.countries`. Each item uses `code` (calling code without `+`), `region` (country symbol), and `name`. Set `admin-ui.auth.registration.default_country` to the desired region; the default is `IN`. The package's default list includes India, United States, and United Kingdom. The Host can replace or extend the list in its published configuration.
