import AdminUiOffcanvas from '../vendor/admin-ui/components/Offcanvas.js';

(function () {
    'use strict';

    const drawer = document.getElementById('customer-demo-offcanvas');
    const payloadOutput = document.getElementById('offcanvas-demo-payload');
    const statusOutput = document.getElementById('offcanvas-demo-status');
    const resetButton = document.getElementById('offcanvas-reset-demo');

    if (!drawer) return;

    const offcanvas = AdminUiOffcanvas.get(drawer) || new AdminUiOffcanvas(drawer);

    drawer.addEventListener('rai:offcanvas:submit', (event) => {
        const { formData, offcanvas: drawerInstance } = event.detail;
        const payload = Object.fromEntries(formData.entries());
        payload.send_welcome = formData.has('send_welcome');

        payloadOutput.textContent = JSON.stringify(payload, null, 2);
        statusOutput.textContent = 'Host received the form data. Simulating a save…';

        // Demo only: replace this timeout with the Host application's API call.
        window.setTimeout(() => {
            drawerInstance.setLoading(false);
            statusOutput.textContent = 'Demo save successful. No data was sent to a server.';
            drawerInstance.close();
        }, 900);
    });

    resetButton?.addEventListener('click', () => {
        offcanvas.reset();
        payloadOutput.textContent = 'No submission yet.';
        statusOutput.textContent = 'Demo has been reset.';
    });

    window.addEventListener('pagehide', () => offcanvas.destroy(), { once: true });
}());
