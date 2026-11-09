# Location-aware pages

Use `LocationAwarePage` only on pages that need browser geolocation. It extends the minimal `BasePage` and provides shared location state plus the package Location Status Dialog. Pages without a location requirement should continue to extend `BasePage`.

## Import and extend

A host page module in `resources/js/pages` can import the published class like this:

```js
import LocationAwarePage from '../vendor/admin-ui/core/LocationAwarePage.js';

export default class LoginPage extends LocationAwarePage {
    init() {
        if (!this.root || !super.init()) return false;

        this.registerEvents();

        // Start requesting location as soon as this page initializes.
        this.locationPromise = this.requireLocation();

        return true;
    }
}
```

## Available methods

- `requestLocation(options)`: requests a fresh location and returns the location object, or `null` on failure. Does not show a dialog.
- `requireLocation(options)`: requests a fresh location and shows the shared non-cancellable Location dialog on failure. The dialog's OK button retries.
- `getLocation()`: returns the location obtained by this page, or `null`.
- `hasLocation()`: reports whether this page has a location.
- `getLocationAccuracy()`: returns browser-reported accuracy in meters.
- `isLocationAccurate(maxAccuracy)`: informational accuracy check.
- `clearLocation()`: clears this page's location and invalidates an in-flight request.

Location options include `enableHighAccuracy`, `timeout`, and `maximumAge`. Defaults are high accuracy, 20 seconds, and zero cache age.

## Add location to a form

Wait for the page-load request before allowing the request to continue:

```js
async handleLoginSubmit(event) {
    event.preventDefault();

    if (this.locationPromise) {
        await this.locationPromise;
    }

    if (!this.hasLocation()) {
        // A failed page-load attempt already displayed the Location dialog.
        // If the user submits again later, start another attempt.
        this.locationPromise = this.requireLocation();
        return;
    }

    const formData = new FormData(this.form);
    const location = this.getLocation();

    formData.set('latitude', String(location.latitude));
    formData.set('longitude', String(location.longitude));
    formData.set('accuracy', String(location.accuracy));

    // Send formData with the host application's API endpoint.
}
```

If location is mandatory, do not send the form/API request until `hasLocation()` is true. The browser may suppress a repeat permission prompt after the user has denied permission; in that case the user must change the site's permission in browser settings.

Browser geolocation requires HTTPS in production (localhost is permitted for development). Browser-reported coordinates and accuracy are user-device signals, not proof of identity or trusted geofencing evidence.
