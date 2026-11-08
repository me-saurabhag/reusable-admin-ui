import PinInput from '../vendor/admin-ui/inputs/PinInput.js';
import Pagination from '../vendor/admin-ui/components/Pagination.js';

(function () {
    'use strict';

    const pinContainer = document.querySelector('[data-rai-pin-input]');
    const pinForm = document.getElementById('pin-input-test-form');
    const pinStatus = document.getElementById('pin-test-status');
    const hiddenValue = document.getElementById('pin-hidden-value');
    const clearButton = document.getElementById('pin-clear-button');
    const fillButton = document.getElementById('pin-fill-button');

    if (pinContainer && pinForm) {
        const pinInput = new PinInput(pinContainer);
        const hiddenField = pinContainer.querySelector('[data-pin-value]');

        pinContainer.addEventListener('rai:pin-input', (event) => {
            const { value, complete } = event.detail;
            pinStatus.textContent = complete
                ? 'Complete — all 6 digits entered.'
                : `${value.length} of 6 digits entered.`;
            hiddenValue.textContent = value || '(empty)';
        });

        hiddenValue.textContent = hiddenField?.value || '(empty)';

        clearButton?.addEventListener('click', () => {
            pinInput.clear();
            pinStatus.textContent = 'PIN cleared.';
            hiddenValue.textContent = '(empty)';
        });

        fillButton?.addEventListener('click', () => pinInput.setDigits('482619'));

        pinForm.addEventListener('submit', (event) => {
            event.preventDefault();
            if (!pinInput.isComplete()) {
                pinStatus.textContent = 'Please enter all 6 digits before testing.';
                pinInput.focus();
                return;
            }

            pinStatus.textContent = `Submit test passed. Captured ${pinInput.getValue().length} digits (value is not sent anywhere).`;
        });
    }

    const rowsContainer = document.getElementById('pagination-test-rows');
    const controlsContainer = document.getElementById('pagination-test-controls');
    const paginationState = document.getElementById('pagination-test-state');

    if (!rowsContainer || !controlsContainer) return;

    const customers = Array.from({ length: 53 }, (_, index) => {
        const number = index + 1;
        return {
            id: number,
            name: `Customer ${String(number).padStart(3, '0')}`,
            email: `customer${number}@example.test`,
            active: number % 4 !== 0,
        };
    });

    const perPage = 8;
    const pagination = new Pagination((page) => renderPage(page));

    function escapeHtml(value) {
        return String(value).replace(/[&<>"']/g, (character) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;',
        })[character]);
    }

    function renderPage(page) {
        const lastPage = Math.max(1, Math.ceil(customers.length / perPage));
        const currentPage = Math.min(lastPage, Math.max(1, Number(page) || 1));
        const start = (currentPage - 1) * perPage;
        const visibleCustomers = customers.slice(start, start + perPage);

        rowsContainer.innerHTML = visibleCustomers.map((customer) => `
            <tr>
                <td><strong>${escapeHtml(customer.name)}</strong><div class="small text-secondary">ID: ${customer.id}</div></td>
                <td>${escapeHtml(customer.email)}</td>
                <td><span class="rai-badge ${customer.active ? 'rai-badge--success' : 'rai-badge--neutral'}">${customer.active ? 'Active' : 'Inactive'}</span></td>
            </tr>
        `).join('');

        const metadata = {
            current_page: currentPage,
            last_page: lastPage,
            total: customers.length,
            per_page: perPage,
        };

        controlsContainer.innerHTML = pagination.render(metadata, { itemName: 'customers' });
        paginationState.textContent = `Showing local sample page ${currentPage} of ${lastPage}. No network request was made.`;
    }

    pagination.bindEvents(controlsContainer);
    renderPage(1);

    window.addEventListener('pagehide', () => pagination.destroy(), { once: true });
}());
