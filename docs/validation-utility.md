# Validation Utility

## Publishing

The package publishes `Validation.js` through the existing `admin-ui-core` tag to:

`resources/js/vendor/admin-ui/core/Validation.js`

The package does not need its own Vite configuration or build step. The Host Application's Vite setup compiles this file when it is imported by a host entry point such as `resources/js/pages/LoginPage.js`.

## Initialization

Import and initialize once before using the String prototype helpers:

```js
import Validation from '../vendor/admin-ui/core/Validation.js';

Validation.init();
```

For a host page at `resources/js/pages/LoginPage.js`, that relative import path is correct.

## Available helpers

| Helper | Purpose |
|---|---|
| `isValidMobile()` | Validates a 10-digit Indian mobile number beginning 6–9 |
| `isNumber()` | Digits only |
| `isValidEmail()` | Basic email format |
| `isValidPassword()` | At least 8 characters, one lowercase, one uppercase and one digit |
| `isValidPinCode()` | Six digits |
| `isValidAadhaar()` | 12 digits, first digit 2–9; format check only, not Aadhaar verification |
| `isUuid4()` | UUID version 4 format |
| `isBlank()` | Empty or whitespace-only |
| `isNumeric()` | Signed integer or decimal format |
| `isInteger()` | Signed whole integer |
| `isPositiveNumber()` | Numeric value greater than zero |
| `isPositiveInteger()` | Integer greater than zero |
| `isNonNegativeNumber()` | Numeric value greater than or equal to zero |

## Login example

```js
const email = this.emailInput?.value?.trim() ?? '';
const password = this.passwordInput?.value ?? '';

if (!email.isValidEmail()) {
    this.toast?.error('Enter a valid email');
    this.emailInput?.focus();
    return;
}

if (password.isBlank()) {
    this.toast?.error('Please enter your password');
    this.passwordInput?.focus();
    return;
}
```

Call `Validation.init()` before these methods are used. These helpers are client-side convenience checks only; the Host Application must always validate input again on the server.
