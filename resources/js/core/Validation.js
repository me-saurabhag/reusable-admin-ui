class Validation {
    static init() {
        if (!String.prototype.isValidMobile) {
            String.prototype.isValidMobile = function () {
                return /^[6-9]\d{9}$/.test(this);
            };
        }

        if (!String.prototype.isNumber) {
            String.prototype.isNumber = function () {
                return /^\d+$/.test(this);
            };
        }

        if (!String.prototype.isValidEmail) {
            String.prototype.isValidEmail = function () {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this);
            };
        }

        if (!String.prototype.isValidPassword) {
            String.prototype.isValidPassword = function () {
                return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(this);
            };
        }

        if (!String.prototype.isValidPinCode) {
            String.prototype.isValidPinCode = function () {
                return /^\d{6}$/.test(this);
            };
        }

        if (!String.prototype.isValidAadhaar) {
            String.prototype.isValidAadhaar = function () {
                return /^[2-9][0-9]{11}$/.test(this);
            };
        }

        if (!String.prototype.isUuid4) {
            String.prototype.isUuid4 = function () {
                return /^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i.test(this);
            };
        }

        /**
         * True if string is empty or only whitespace.
         */
        if (!String.prototype.isBlank) {
            String.prototype.isBlank = function () {
                return this.trim() === '';
            };
        }

        /**
         * True if string represents any number (int or decimal),
         * optionally with a leading minus sign.
         * Rejects "", "abc", "1e3", Infinity, NaN.
         */
        if (!String.prototype.isNumeric) {
            String.prototype.isNumeric = function () {
                const value = this.trim();
                if (value === '') return false;
                return /^-?\d+(\.\d+)?$/.test(value);
            };
        }

        /**
         * True if string represents a whole integer (no decimals).
         * Allows negative, e.g. "-5".
         */
        if (!String.prototype.isInteger) {
            String.prototype.isInteger = function () {
                const value = this.trim();
                if (value === '') return false;
                return /^-?\d+$/.test(value);
            };
        }

        /**
         * True if string represents a number strictly greater than 0.
         * Accepts "1", "1.5", "0.01". Rejects "0", "-1", "".
         */
        if (!String.prototype.isPositiveNumber) {
            String.prototype.isPositiveNumber = function () {
                return this.isNumeric() && Number(this) > 0;
            };
        }

        /**
         * True if string represents a whole integer > 0.
         * Ideal for IDs (account id, user id, etc.).
         */
        if (!String.prototype.isPositiveInteger) {
            String.prototype.isPositiveInteger = function () {
                return this.isInteger() && Number(this) > 0;
            };
        }

        /**
         * True if string represents a number >= 0.
         * Accepts "0", "3", "0.25". Rejects "-1", "".
         */
        if (!String.prototype.isNonNegativeNumber) {
            String.prototype.isNonNegativeNumber = function () {
                return this.isNumeric() && Number(this) >= 0;
            };
        }
    }
}

export default Validation;
