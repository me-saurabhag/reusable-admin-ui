# Pagination and Transaction PIN Input

## Components included

- `resources/js/components/Pagination.js` — client-side pagination renderer and callback.
- `resources/css/components/pagination.css` — styling for `.common-pagination-*`.
- `resources/views/components/pagination.blade.php` — existing server-rendered Laravel paginator component remains available.
- `resources/js/inputs/PinInput.js` — digit-by-digit PIN input behavior.
- `resources/views/components/pin-input.blade.php` — new Transaction PIN input UI.
- `resources/css/components/pin-input.css` — responsive masked PIN input styling.

## Publish

The assets are included in `admin-ui-core` and also have focused tags:

```bash
php artisan vendor:publish --tag=admin-ui-core --force
```

Optional focused publishing:

```bash
php artisan vendor:publish --tag=admin-ui-inputs --force
php artisan vendor:publish --tag=admin-ui-pagination --force
```

The Host main stylesheet imports both CSS files, and the Host main `app.js` imports both JavaScript modules. Run:

```bash
php artisan optimize:clear
npm run build
```

## Transaction PIN Blade usage

```blade
<form id="transactionPinForm">
    <x-admin-ui::pin-input
        name="transaction_pin"
        label="Transaction PIN"
        description="Enter your 6-digit transaction PIN."
        :length="6"
    />

    <button type="submit">Continue</button>
</form>
```

The component renders six masked boxes and a hidden field named `transaction_pin`. The `PinInput` class synchronizes the hidden field as the user types or pastes. The Host application must still validate the PIN server-side.

## Transaction PIN JavaScript

```js
import PinInput from '../vendor/admin-ui/inputs/PinInput.js';

const pinContainer = document.querySelector('[data-rai-pin-input]');
const pinInput = new PinInput(pinContainer);

console.log(pinInput.getValue());
console.log(pinInput.isComplete());

pinInput.clear();
pinInput.focus();

// Optional cleanup when the containing page/component is destroyed:
pinInput.destroy();
```

If the Host `app.js` entry is loaded, the class is also exposed as:

```js
const pinInput = new window.AdminUiPinInput(
    document.querySelector('[data-rai-pin-input]')
);
```

The input emits a bubbling `rai:pin-input` event with `{ value, complete }` in `event.detail`.

## Client-side Pagination usage

```js
import Pagination from '../vendor/admin-ui/components/Pagination.js';

const paginationElement = document.querySelector('#contactsPagination');

const pagination = new Pagination(async (page) => {
    const response = await ApiClient.get(`/api/contacts?page=${page}`);

    // Host application updates its table rows using response.data.
    renderContactRows(response.data);

    paginationElement.innerHTML = pagination.render(response.meta, {
        itemName: 'contacts',
    });

    if (window.feather) window.feather.replace();
});

paginationElement.innerHTML = pagination.render(initialPaginationMeta, {
    itemName: 'contacts',
});
pagination.bindEvents(paginationElement);
```

The callback receives the requested page number. It does not make HTTP requests or fetch records by itself. The Host application supplies updated Laravel-style pagination metadata (`current_page`, `last_page`, `total`, `per_page`) after its API request.

For normal Laravel server-rendered pages, continue using the existing Blade component:

```blade
<x-admin-ui::pagination :paginator="$contacts" />
```

## Design and responsibility boundaries

- PinInput manages input focus, digit filtering, paste, clear and value retrieval.
- Pagination renders controls and reports the selected page.
- Host code owns server requests, authorization, validation, PIN verification and table data.
