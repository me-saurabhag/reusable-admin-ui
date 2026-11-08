# Right Offcanvas – Implementation

## Component

The package now provides a shared right-side form drawer:

```blade
<x-admin-ui::offcanvas
    id="customer-offcanvas"
    title="Add customer"
    subtitle="Enter customer details."
    width="560px"
    submit-label="Save customer"
    cancel-label="Cancel"
>
    <x-admin-ui::input name="name" label="Full name" required />
    <x-admin-ui::input name="email" type="email" label="Email address" required />
</x-admin-ui::offcanvas>
```

The component owns the header, close control, scrollable body, footer, native browser validation, submit loading state, and Bootstrap Offcanvas lifecycle. The Host supplies the body fields and owns all business validation, API requests, authorization, persistence, error display, and success decisions.

Supported props:

- `id` (required): unique drawer ID.
- `title`, `subtitle`: header content.
- `width`: px, vw, or % value, e.g. `560px`, `45vw`, `70%`.
- `formId`: optional custom form ID; defaults to `{id}-form`.
- `submitLabel`, `cancelLabel`: footer labels.
- `showFooter`: show/hide the standard footer.
- `submitDisabled`: initial submit-button disabled state.

An optional `headerActions` slot can add Host-provided controls beside the heading. The default Bootstrap backdrop and Escape-key behavior are retained.

## Host submit integration

The component dispatches a bubbling `rai:offcanvas:submit` event from the drawer. `event.detail` contains:

- `formData`: a `FormData` instance with the current form values.
- `form`: the form element.
- `offcanvas`: the component controller.

Example Host integration:

```js
const drawer = document.getElementById('customer-offcanvas');

drawer.addEventListener('rai:offcanvas:submit', async (event) => {
    const { formData, offcanvas } = event.detail;

    try {
        // Call the Host application's API/service here.
        await saveCustomer(formData);
        offcanvas.close();
    } catch (error) {
        // Show Host validation/API errors here.
        offcanvas.setLoading(false);
    }
});
```

Controller methods:

- `open()` – show the drawer.
- `close()` – clear loading state and hide the drawer.
- `setLoading(true|false, optionalLabel)` – control submit loading state.
- `isLoading()` – check loading state.
- `reset()` – reset form fields and loading state.
- `destroy()` – remove the form listener and dispose the Bootstrap instance.
- `AdminUiOffcanvas.get(elementOrId)` – retrieve an initialized instance.
- `AdminUiOffcanvas.initAll(root)` – initialize all package drawers under a root element.

The controller initializes drawers automatically and is also available as `window.AdminUiOffcanvas` after the Host `app.js` entry loads.

## Demo page

Host-only interactive demo:

`/admin-ui/offcanvas-demo`

It uses local demo data only. The submit handler simulates a save, shows the received payload, and closes the drawer. It does not make a network request or write to the database.

## Publishing

The new assets are included in `admin-ui-core` and are also available through the focused `admin-ui-offcanvas` publish tag:

```bash
php artisan vendor:publish --tag=admin-ui-offcanvas --force
```

For a complete package asset refresh:

```bash
php artisan vendor:publish --tag=admin-ui-core --force
```

The Host Vite entry imports the published JS module and CSS file. No package-side NPM build step is required.
