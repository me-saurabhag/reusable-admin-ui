# Input and Pagination Test Page

A Host-application-only demo page is available at:

`/admin-ui/test-input-pagination`

It demonstrates the package PIN input and JavaScript Pagination components together on the shared admin layout.

## PIN input checks

- Enter six digits and verify focus advances automatically.
- Use Backspace and left/right arrow keys.
- Paste a six-digit value into any PIN box.
- Use **Fill sample** and **Clear**.
- Submit the form to verify the component's current value and completion state.
- Confirm the hidden `demo_pin` field is synchronized. The demo never sends the PIN to a server.

## Pagination checks

- Displays 53 local sample customers, 8 per page.
- Test first, previous, numbered, next, and last-page controls.
- Verify the visible table rows and pagination summary update together.
- All pagination is client-side; no API request is made.

## Host files added

- `resources/views/admin-ui-input-pagination-test.blade.php`
- `resources/js/pages/input-pagination-test.js`
- Route: `admin-ui.test-input-pagination`
- Vite entry: `resources/js/pages/input-pagination-test.js`

The page is a development/test utility. Remove its route and view if you do not want to expose it in the deployed application.
