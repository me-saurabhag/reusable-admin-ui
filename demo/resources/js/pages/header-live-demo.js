// Root-page demonstration: update Header cards after the initial Blade render.
// In production, call these methods from your API/WebSocket/SSE success handler.
(function () {
    'use strict';

    if (!document.getElementById('header-live-demo')) return;

    window.setTimeout(function () {
        if (!window.AdminUi || !window.AdminUi.header) return;

        window.AdminUi.header.updateCards({
            wallet_balance: {
                value: 1899.75,
                format: 'currency',
                currency: 'INR',
                locale: 'en-IN',
                decimals: 2
            },
            otp_credit: {
                value: 325,
                format: 'number',
                suffix: 'Credits'
            }
        });

        document.dispatchEvent(new CustomEvent('header-live-demo:updated'));
    }, 2500);
}());
