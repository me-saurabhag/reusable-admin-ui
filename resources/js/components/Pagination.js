/**
 * Pagination
 *
 * Client-side pagination controls for Laravel-style paginator metadata.
 * The Host application fetches data and supplies the new paginator state.
 */
export default class Pagination {
    constructor(onPageChange) {
        if (typeof onPageChange !== 'function') {
            throw new TypeError('Pagination requires an onPageChange(page) callback.');
        }

        this.onPageChange = onPageChange;
        this.abort = new AbortController();
        this.boundContainers = new WeakSet();
    }

    render(pagination, options = {}) {
        const lastPage = Math.max(1, Number(pagination?.last_page) || 1);
        const currentPage = Math.min(lastPage, Math.max(1, Number(pagination?.current_page) || 1));
        const total = Math.max(0, Number(pagination?.total) || 0);
        const perPage = Math.max(0, Number(pagination?.per_page) || 0);
        const itemName = this.escapeHtml(options.itemName || 'records');

        const fromRecord = total === 0 ? 0 : ((currentPage - 1) * perPage) + 1;
        const toRecord = Math.min(currentPage * perPage, total);

        return `
            <div class="common-pagination-section">
                <div class="common-pagination-info">
                    Showing <strong>${fromRecord}</strong> to
                    <strong>${toRecord}</strong> of <strong>${total}</strong>
                    ${itemName}
                </div>
                <div class="common-pagination-wrapper">
                    <ul class="common-pagination" aria-label="Pagination">
                        ${this.build(currentPage, lastPage)}
                    </ul>
                </div>
            </div>
        `;
    }

    bindEvents(container) {
        if (!container || this.boundContainers.has(container)) return;

        container.addEventListener('click', (event) => {
            const target = event.target;
            if (!(target instanceof Element)) return;

            const button = target.closest('[data-page]');
            if (!button || !container.contains(button) || button.disabled) return;

            const page = Number(button.dataset.page);
            if (!Number.isInteger(page) || page < 1) return;

            this.onPageChange(page);
        }, { signal: this.abort.signal });

        this.boundContainers.add(container);
    }

    build(currentPage, lastPage) {
        const pageButton = (page, label, title, disabled = false, icon = '') => `
            <li class="page-item ${disabled ? 'disabled' : ''}">
                <button
                    type="button"
                    class="page-link"
                    data-page="${page}"
                    title="${title}"
                    aria-label="${title}"
                    ${disabled ? 'disabled aria-disabled="true"' : ''}
                >${icon || label}</button>
            </li>
        `;

        let html = '';
        html += pageButton(1, '1', 'First Page', currentPage === 1, '<i data-feather="chevrons-left" aria-hidden="true"></i>');
        html += pageButton(currentPage - 1, 'Previous', 'Previous Page', currentPage === 1, '<i data-feather="chevron-left" aria-hidden="true"></i>');

        this.getPages(currentPage, lastPage).forEach((page) => {
            if (page === '...') {
                html += '<li class="page-item pagination-dots"><span class="page-link" aria-hidden="true">…</span></li>';
                return;
            }

            const active = page === currentPage;
            html += `
                <li class="page-item ${active ? 'active' : ''}">
                    <button
                        type="button"
                        class="page-link"
                        data-page="${page}"
                        ${active ? 'aria-current="page" aria-label="Page ' + page + ', current page"' : 'aria-label="Go to page ' + page + '"'}
                    >${page}</button>
                </li>
            `;
        });

        html += pageButton(currentPage + 1, 'Next', 'Next Page', currentPage === lastPage, '<i data-feather="chevron-right" aria-hidden="true"></i>');
        html += pageButton(lastPage, 'Last', 'Last Page', currentPage === lastPage, '<i data-feather="chevrons-right" aria-hidden="true"></i>');

        return html;
    }

    getPages(currentPage, lastPage) {
        if (lastPage <= 7) {
            return Array.from({ length: lastPage }, (_, index) => index + 1);
        }

        if (currentPage <= 4) {
            return [1, 2, 3, 4, 5, '...', lastPage - 1, lastPage];
        }

        if (currentPage >= lastPage - 3) {
            return [1, 2, '...', lastPage - 4, lastPage - 3, lastPage - 2, lastPage - 1, lastPage];
        }

        return [1, '...', currentPage - 2, currentPage - 1, currentPage, currentPage + 1, currentPage + 2, '...', lastPage];
    }

    escapeHtml(value) {
        return String(value).replace(/[&<>"']/g, (character) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        })[character]);
    }

    destroy() {
        this.abort.abort();
    }
}

if (typeof window !== 'undefined') {
    window.AdminUiPagination ??= Pagination;
}
