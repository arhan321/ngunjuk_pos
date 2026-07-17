document.addEventListener('DOMContentLoaded', () => {
    const qs = (selector, parent = document) => parent.querySelector(selector);

    const historyArea = qs('.history-area');
    const historyBody = qs('#historyBody');
    const historyEmpty = qs('#historyEmpty');
    const historySearch = qs('#historySearch');
    const historyDateFilter = qs('#historyDateFilter');
    const historySort = qs('#historySort');
    const historyStatus = qs('#historyStatus');

    const historyTableWrap = qs('.history-table-wrap');
    const historyPagination = qs('#historyPagination');
    const historyPrevPage = qs('#historyPrevPage');
    const historyNextPage = qs('#historyNextPage');
    const historyPageInfo = qs('#historyPageInfo');

    const statProductsSold = qs('#statProductsSold');
    const statOrders = qs('#statOrders');
    const statSales = qs('#statSales');

    const exportHistory = qs('#exportHistory');
    const toast = qs('#toast');

    const invoiceModal = qs('#invoiceModal');
    const invoiceModalBackdrop = qs('#invoiceModalBackdrop');
    const closeInvoiceModal = qs('#closeInvoiceModal');
    const closeInvoiceModalBottom = qs('#closeInvoiceModalBottom');
    const printInvoice = qs('#printInvoice');

    const invoiceOrderCode = qs('#invoiceOrderCode');
    const invoiceCode = qs('#invoiceCode');
    const invoiceDate = qs('#invoiceDate');
    const invoiceStatus = qs('#invoiceStatus');
    const invoiceItems = qs('#invoiceItems');
    const invoiceTotalItem = qs('#invoiceTotalItem');
    const invoiceTotalPrice = qs('#invoiceTotalPrice');

    const perPage = 10;

    const state = {
        orders: [],
        selectedOrder: null,
        currentPage: 1,
        searchTimer: null,
        isLoading: false,
        paginationTicking: false,
    };

    if (!historyBody || !window.NGUNJUK_ROUTES?.historyApi) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Floating Pagination
    |--------------------------------------------------------------------------
    | Pagination dipindahkan ke dalam .history-area supaya tidak ikut menjadi
    | isi scroll tabel. Tombol pagination akan muncul hanya ketika data history
    | sudah mendekati bagian bawah / data terakhir sudah terlihat.
    */
    if (historyArea && historyPagination && historyPagination.parentElement !== historyArea) {
        historyArea.appendChild(historyPagination);
    }

    if (historyTableWrap) {
        historyTableWrap.style.scrollBehavior = 'smooth';
    }

    function escapeHTML(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(Number(value || 0));
    }

    function formatDateTime(value) {
        if (!value) {
            return '-';
        }

        const date = new Date(String(value).replace(' ', 'T'));

        if (Number.isNaN(date.getTime())) {
            return value;
        }

        return new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        }).format(date);
    }

    function formatReceiptDateTime(value) {
        if (!value) {
            return '-';
        }

        const date = new Date(String(value).replace(' ', 'T'));

        if (Number.isNaN(date.getTime())) {
            return escapeHTML(value);
        }

        return new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        }).format(date);
    }

    function showToast(message) {
        if (!toast) {
            return;
        }

        toast.textContent = message;
        toast.classList.add('show');

        window.setTimeout(() => {
            toast.classList.remove('show');
        }, 2200);
    }

    function getStatusClass(status) {
        const normalizedStatus = String(status || '').toLowerCase();

        if (normalizedStatus.includes('selesai')) {
            return 'done';
        }

        if (normalizedStatus.includes('proses')) {
            return 'process';
        }

        if (normalizedStatus.includes('batal')) {
            return 'cancel';
        }

        return '';
    }

    function getTotalItem(items) {
        if (!Array.isArray(items)) {
            return 0;
        }

        return items.reduce((total, item) => {
            return total + Number(item.quantity || 0);
        }, 0);
    }

    function itemToText(item) {
        const productName = item?.product_name || '-';
        const size = item?.size || 'Regular';
        const quantity = Number(item?.quantity || 0);
        const note = item?.note ? ` | Catatan: ${item.note}` : '';

        return `${productName} (${size}) x${quantity}${note}`;
    }

    function renderItemSummary(items) {
        if (!Array.isArray(items) || items.length === 0) {
            return '<span>-</span>';
        }

        const firstItem = items[0];
        const remainingItems = items.slice(1);
        const firstNote = firstItem.note ? escapeHTML(firstItem.note) : '';

        return `
            <div class="history-item-summary">
                <div class="history-item-summary-main">
                    <strong>${escapeHTML(firstItem.product_name || '-')}</strong>
                </div>

                ${
                    firstNote
                        ? `<small class="history-item-summary-note">Catatan: ${firstNote}</small>`
                        : ''
                }

                ${
                    remainingItems.length > 0
                        ? `
                            <button
                                class="history-more-toggle"
                                type="button"
                                data-collapsed-text="+${remainingItems.length} item lainnya"
                                data-expanded-text="Tutup item lainnya"
                                aria-expanded="false"
                            >
                                +${remainingItems.length} item lainnya
                            </button>

                            <div class="history-extra-items">
                                ${remainingItems.map((item) => {
                                    const note = item.note ? escapeHTML(item.note) : '';

                                    return `
                                        <div class="history-extra-item-card">
                                            <div class="history-extra-item-main">
                                                <strong>${escapeHTML(item.product_name || '-')}</strong>
                                            </div>

                                            ${
                                                note
                                                    ? `<small>Catatan: ${note}</small>`
                                                    : ''
                                            }
                                        </div>
                                    `;
                                }).join('')}
                            </div>
                        `
                        : ''
                }
            </div>
        `;
    }

    function setLoadingRow() {
        historyBody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align:center; padding:32px;">
                    Memuat data history...
                </td>
            </tr>
        `;

        if (historyEmpty) {
            historyEmpty.style.display = 'none';
            historyEmpty.classList.remove('show');
        }

        if (historyPagination) {
            historyPagination.style.display = 'none';
            historyPagination.classList.remove('show');
        }

        historyArea?.classList.remove('show-history-pagination');
    }

    function renderSummary(summary) {
        if (statProductsSold) {
            statProductsSold.textContent = `${summary?.today_products_sold ?? 0} item`;
        }

        if (statOrders) {
            statOrders.textContent = summary?.today_total_order ?? 0;
        }

        if (statSales) {
            statSales.textContent = formatRupiah(summary?.today_total_sales ?? 0);
        }
    }

    function getTotalPage() {
        return Math.max(1, Math.ceil(state.orders.length / perPage));
    }

    function getPaginatedOrders() {
        const totalPage = getTotalPage();

        if (state.currentPage > totalPage) {
            state.currentPage = totalPage;
        }

        if (state.currentPage < 1) {
            state.currentPage = 1;
        }

        const startIndex = (state.currentPage - 1) * perPage;
        const endIndex = startIndex + perPage;

        return state.orders.slice(startIndex, endIndex);
    }

    function renderPagination() {
        if (!historyPagination || !historyPrevPage || !historyNextPage || !historyPageInfo) {
            return;
        }

        if (!state.orders.length) {
            historyPagination.style.display = 'none';
            historyPagination.classList.remove('show');
            historyArea?.classList.remove('show-history-pagination');
            return;
        }

        const totalPage = getTotalPage();

        historyPagination.style.display = 'flex';
        historyPagination.classList.add('show');

        historyPageInfo.textContent = `Halaman ${state.currentPage} dari ${totalPage}`;
        historyPrevPage.disabled = state.currentPage <= 1;
        historyNextPage.disabled = state.currentPage >= totalPage;
    }

    function updateHistoryPaginationFloating() {
        if (!historyArea || !historyTableWrap || !historyPagination || !historyBody) {
            return;
        }

        if (!state.orders.length || historyPagination.style.display === 'none') {
            historyArea.classList.remove('show-history-pagination');
            return;
        }

        const rows = historyBody.querySelectorAll('tr');
        const lastRow = rows[rows.length - 1];

        if (!lastRow) {
            historyArea.classList.remove('show-history-pagination');
            return;
        }

        const currentScroll = historyTableWrap.scrollTop;
        const tableHeight = historyTableWrap.clientHeight;
        const totalScrollHeight = historyTableWrap.scrollHeight;
        const maxScroll = totalScrollHeight - tableHeight;

        const wrapRect = historyTableWrap.getBoundingClientRect();
        const lastRowRect = lastRow.getBoundingClientRect();

        const nearBottom = currentScroll + tableHeight >= totalScrollHeight - 90;

        const lastRowVisibleAtBottom =
            lastRowRect.bottom <= wrapRect.bottom + 20 &&
            lastRowRect.bottom >= wrapRect.top;

        const shouldShowPagination = maxScroll > 4 && (nearBottom || lastRowVisibleAtBottom);

        historyArea.classList.toggle('show-history-pagination', shouldShowPagination);
    }

    function requestHistoryPaginationFloatingUpdate() {
        if (state.paginationTicking) {
            return;
        }

        state.paginationTicking = true;

        window.requestAnimationFrame(() => {
            updateHistoryPaginationFloating();
            state.paginationTicking = false;
        });
    }

    function scrollHistoryToTop(behavior = 'smooth') {
        if (!historyTableWrap) {
            return;
        }

        historyArea?.classList.remove('show-history-pagination');

        historyTableWrap.scrollTo({
            top: 0,
            behavior,
        });
    }

    function renderHistory() {
        historyBody.innerHTML = '';

        historyArea?.classList.remove('show-history-pagination');

        if (!state.orders.length) {
            if (historyEmpty) {
                historyEmpty.style.display = 'grid';
                historyEmpty.classList.add('show');
            }

            renderPagination();
            return;
        }

        if (historyEmpty) {
            historyEmpty.style.display = 'none';
            historyEmpty.classList.remove('show');
        }

        const paginatedOrders = getPaginatedOrders();

        paginatedOrders.forEach((order) => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>${escapeHTML(order.order_code || '-')}</td>

                <td>${renderItemSummary(order.items)}</td>

                <td>${formatDateTime(order.ordered_at || order.ordered_at_human)}</td>

                <td>${formatRupiah(order.total_price || 0)}</td>

                <td>
                    <span class="status-pill ${getStatusClass(order.status)}">
                        ${escapeHTML(order.status || '-')}
                    </span>
                </td>

                <td>
                    <button
                        class="history-detail-btn"
                        type="button"
                        data-order-code="${escapeHTML(order.order_code || '')}"
                    >
                        Detail / Struk
                    </button>
                </td>
            `;

            historyBody.appendChild(row);
        });

        renderPagination();
        requestHistoryPaginationFloatingUpdate();
    }

    function buildHistoryUrl() {
        const url = new URL(window.NGUNJUK_ROUTES.historyApi, window.location.origin);

        const searchValue = historySearch?.value?.trim() || '';
        const statusValue = historyStatus?.value || 'all';
        const dateFilterValue = historyDateFilter?.value || 'today';
        const sortValue = historySort?.value || 'latest';

        if (searchValue) {
            url.searchParams.set('search', searchValue);
        }

        url.searchParams.set('status', statusValue);
        url.searchParams.set('date_filter', dateFilterValue);
        url.searchParams.set('sort', sortValue);
        url.searchParams.set('_', Date.now().toString());

        return url.toString();
    }

    async function loadHistory() {
        if (state.isLoading) {
            return;
        }

        state.isLoading = true;
        setLoadingRow();

        try {
            const response = await fetch(buildHistoryUrl(), {
                method: 'GET',
                cache: 'no-store',
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Gagal mengambil data history.');
            }

            state.orders = Array.isArray(result.data) ? result.data : [];
            state.currentPage = 1;

            renderSummary(result.summary || {});
            renderHistory();
            scrollHistoryToTop('auto');
        } catch (error) {
            renderSummary({
                today_products_sold: 0,
                today_total_order: 0,
                today_total_sales: 0,
            });

            state.orders = [];
            state.currentPage = 1;

            renderHistory();
            showToast('Gagal mengambil data history.');
        } finally {
            state.isLoading = false;
        }
    }

    function renderInvoice(order) {
        if (!order) {
            return;
        }

        const totalItem = getTotalItem(order.items);

        state.selectedOrder = order;

        if (invoiceOrderCode) {
            invoiceOrderCode.textContent = order.order_code || '-';
        }

        if (invoiceCode) {
            invoiceCode.textContent = order.order_code || '-';
        }

        if (invoiceDate) {
            invoiceDate.textContent = formatDateTime(order.ordered_at || order.ordered_at_human);
        }

        if (invoiceStatus) {
            invoiceStatus.textContent = order.status || '-';
        }

        if (invoiceTotalItem) {
            invoiceTotalItem.textContent = `${totalItem} item`;
        }

        if (invoiceTotalPrice) {
            invoiceTotalPrice.textContent = formatRupiah(order.total_price || 0);
        }

        if (!invoiceItems) {
            return;
        }

        if (!Array.isArray(order.items) || order.items.length === 0) {
            invoiceItems.innerHTML = `
                <div class="invoice-item-row">
                    <span>Item tidak tersedia.</span>
                </div>
            `;
            return;
        }

        invoiceItems.innerHTML = order.items.map((item) => {
            const note = item.note ? escapeHTML(item.note) : '';

            return `
                <div class="invoice-item-row">
                    <div>
                        <strong>${escapeHTML(item.product_name || '-')}</strong>
                        <small>${escapeHTML(item.size || 'Regular')} • x${Number(item.quantity || 0)}</small>

                        ${
                            note
                                ? `<small class="invoice-item-note">Catatan: ${note}</small>`
                                : ''
                        }
                    </div>

                    <strong>${formatRupiah(item.subtotal || 0)}</strong>
                </div>
            `;
        }).join('');
    }

    function openInvoice(orderCode) {
        const order = state.orders.find((item) => item.order_code === orderCode);

        if (!order) {
            showToast('Detail order tidak ditemukan.');
            return;
        }

        renderInvoice(order);

        invoiceModal?.classList.add('show');
        invoiceModalBackdrop?.classList.add('show');
    }

    function closeInvoice() {
        invoiceModal?.classList.remove('show');
        invoiceModalBackdrop?.classList.remove('show');
    }

    function buildPrintHtml(order) {
        const totalItem = getTotalItem(order.items);
        const totalPrice = Number(order?.total_price || 0);
        const orderedAt = order?.ordered_at || order?.ordered_at_human || new Date().toISOString();
        const items = Array.isArray(order?.items) ? order.items : [];

        const itemRows = items.map((item) => {
            const productName = item.product_name || item.name || '-';
            const sizeName = item.size_name || item.size || 'Regular';
            const quantity = Number(item.quantity || 0);
            const price = Number(item.price || item.unit_price || 0);
            const subtotal = Number(item.subtotal || price * quantity || 0);

            const note = item.note
                ? `<div class="note">Catatan: ${escapeHTML(item.note)}</div>`
                : '';

            return `
                <div class="item">
                    <div class="item-title">
                        <strong>${escapeHTML(productName)}</strong>
                    </div>

                    <div class="item-meta">
                        <span>${escapeHTML(sizeName)} x${quantity}</span>
                        <span>${formatRupiah(price)}</span>
                    </div>

                    ${note}

                    <div class="item-subtotal">
                        <span>Subtotal</span>
                        <strong>${formatRupiah(subtotal)}</strong>
                    </div>
                </div>
            `;
        }).join('');

        return `
            <!DOCTYPE html>
            <html lang="id">
            <head>
                <meta charset="UTF-8">
                <title>Struk ${escapeHTML(order?.order_code || '-')}</title>

                <style>
                    * {
                        box-sizing: border-box;
                    }

                    body {
                        margin: 0;
                        padding: 18px;
                        font-family: Arial, sans-serif;
                        color: #1f1f1f;
                        background: #ffffff;
                    }

                    .receipt {
                        width: 300px;
                        margin: 0 auto;
                    }

                    .center {
                        text-align: center;
                    }

                    .brand {
                        margin-bottom: 4px;
                        font-size: 21px;
                        font-weight: 800;
                        letter-spacing: 1px;
                    }

                    .brand span {
                        color: #e8733d;
                    }

                    .subtitle {
                        font-size: 11px;
                        line-height: 1.4;
                        color: #666666;
                    }

                    .line {
                        border-top: 1px dashed #999999;
                        margin: 12px 0;
                    }

                    .info,
                    .total {
                        display: grid;
                        gap: 6px;
                        font-size: 12px;
                    }

                    .info div,
                    .total div,
                    .item-meta,
                    .item-subtotal {
                        display: flex;
                        justify-content: space-between;
                        gap: 10px;
                    }

                    .info span,
                    .total span {
                        color: #555555;
                    }

                    .item {
                        padding-bottom: 10px;
                        margin-bottom: 10px;
                        border-bottom: 1px dashed #dddddd;
                        font-size: 12px;
                    }

                    .item:last-child {
                        border-bottom: 0;
                        margin-bottom: 0;
                        padding-bottom: 0;
                    }

                    .item-title strong {
                        display: block;
                        font-size: 13px;
                        line-height: 1.35;
                    }

                    .item-meta {
                        margin-top: 4px;
                        color: #666666;
                    }

                    .note {
                        margin-top: 6px;
                        padding: 6px 7px;
                        border-radius: 6px;
                        background: #f4f4f4;
                        color: #444444;
                        font-size: 11px;
                        line-height: 1.35;
                    }

                    .item-subtotal {
                        margin-top: 6px;
                        font-size: 12px;
                    }

                    .grand {
                        padding-top: 7px;
                        border-top: 1px dashed #999999;
                        font-size: 15px;
                        font-weight: 800;
                    }

                    .thanks {
                        margin-top: 14px;
                        font-size: 12px;
                        line-height: 1.5;
                        text-align: center;
                    }

                    .small {
                        margin-top: 4px;
                        color: #666666;
                        font-size: 10px;
                        text-align: center;
                    }

                    @media print {
                        @page {
                            size: 80mm auto;
                            margin: 4mm;
                        }

                        body {
                            padding: 0;
                        }

                        .receipt {
                            width: 100%;
                        }
                    }
                </style>
            </head>

            <body>
                <div class="receipt">
                    <div class="center">
                        <div class="brand"><span>Ngun</span>juk POS</div>
                        <div class="subtitle">
                            Sistem Informasi Kasir<br>
                            UMKM Ngunjuk
                        </div>
                    </div>

                    <div class="line"></div>

                    <div class="info">
                        <div>
                            <span>Order</span>
                            <strong>${escapeHTML(order?.order_code || '-')}</strong>
                        </div>

                        <div>
                            <span>Waktu</span>
                            <strong>${formatReceiptDateTime(orderedAt)}</strong>
                        </div>

                        <div>
                            <span>Status</span>
                            <strong>${escapeHTML(order?.status || 'Selesai')}</strong>
                        </div>
                    </div>

                    <div class="line"></div>

                    ${itemRows || '<div class="item">Item tidak tersedia.</div>'}

                    <div class="line"></div>

                    <div class="total">
                        <div>
                            <span>Total Item</span>
                            <strong>${totalItem} item</strong>
                        </div>

                        <div class="grand">
                            <span>Total</span>
                            <strong>${formatRupiah(totalPrice)}</strong>
                        </div>
                    </div>

                    <div class="line"></div>

                    <div class="thanks">
                        Terima kasih sudah berbelanja.
                    </div>

                    <div class="small">
                        Struk ini dicetak otomatis oleh Ngunjuk POS.
                    </div>
                </div>

                <script>
                    window.onload = function () {
                        window.print();

                        setTimeout(function () {
                            window.close();
                        }, 500);
                    };
                <\/script>
            </body>
            </html>
        `;
    }

    function printSelectedInvoice() {
        if (!state.selectedOrder) {
            showToast('Pilih order terlebih dahulu.');
            return;
        }

        const printWindow = window.open('', '_blank', 'width=420,height=680');

        if (!printWindow) {
            showToast('Pop-up browser diblokir. Izinkan pop-up untuk cetak struk.');
            return;
        }

        printWindow.document.open();
        printWindow.document.write(buildPrintHtml(state.selectedOrder));
        printWindow.document.close();
    }

    function exportCurrentHistory() {
        if (!state.orders.length) {
            showToast('Tidak ada data history untuk diexport.');
            return;
        }

        const headers = [
            'ID Order',
            'Item',
            'Waktu',
            'Total',
            'Status',
        ];

        const rows = state.orders.map((order) => {
            const itemList = Array.isArray(order.items)
                ? order.items.map(itemToText).join(' | ')
                : '-';

            return [
                order.order_code || '-',
                itemList,
                formatDateTime(order.ordered_at || order.ordered_at_human),
                Number(order.total_price || 0),
                order.status || '-',
            ];
        });

        const csvContent = [headers, ...rows]
            .map((row) => {
                return row.map((cell) => {
                    return `"${String(cell).replaceAll('"', '""')}"`;
                }).join(',');
            })
            .join('\n');

        const blob = new Blob([csvContent], {
            type: 'text/csv;charset=utf-8;',
        });

        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');

        const today = new Date().toISOString().slice(0, 10);

        link.href = url;
        link.download = `history-ngunjuk-${today}.csv`;
        link.style.display = 'none';

        document.body.appendChild(link);
        link.click();
        link.remove();

        URL.revokeObjectURL(url);

        showToast('Data history berhasil diexport.');
    }

    function reloadWithDebounce() {
        window.clearTimeout(state.searchTimer);

        state.searchTimer = window.setTimeout(() => {
            loadHistory();
        }, 350);
    }

    historyBody.addEventListener('click', (event) => {
        const detailButton = event.target.closest('.history-detail-btn');

        if (detailButton) {
            openInvoice(detailButton.dataset.orderCode);
            return;
        }

        const moreButton = event.target.closest('.history-more-toggle');

        if (moreButton) {
            const summary = moreButton.closest('.history-item-summary');
            const extraItems = summary?.querySelector('.history-extra-items');

            if (!summary || !extraItems) {
                return;
            }

            const isExpanded = summary.classList.toggle('show-extra');

            extraItems.classList.toggle('show', isExpanded);
            moreButton.setAttribute('aria-expanded', String(isExpanded));
            moreButton.textContent = isExpanded
                ? moreButton.dataset.expandedText
                : moreButton.dataset.collapsedText;

            requestHistoryPaginationFloatingUpdate();
        }
    });

    historyPrevPage?.addEventListener('click', () => {
        if (state.currentPage <= 1) {
            return;
        }

        state.currentPage -= 1;
        renderHistory();
        scrollHistoryToTop();
    });

    historyNextPage?.addEventListener('click', () => {
        const totalPage = getTotalPage();

        if (state.currentPage >= totalPage) {
            return;
        }

        state.currentPage += 1;
        renderHistory();
        scrollHistoryToTop();
    });

    historySearch?.addEventListener('input', reloadWithDebounce);

    historyDateFilter?.addEventListener('change', () => {
        loadHistory();
    });

    historySort?.addEventListener('change', () => {
        loadHistory();
    });

    historyStatus?.addEventListener('change', () => {
        loadHistory();
    });

    historyTableWrap?.addEventListener('scroll', requestHistoryPaginationFloatingUpdate, {
        passive: true,
    });

    window.addEventListener('resize', requestHistoryPaginationFloatingUpdate);

    exportHistory?.addEventListener('click', exportCurrentHistory);

    closeInvoiceModal?.addEventListener('click', closeInvoice);
    closeInvoiceModalBottom?.addEventListener('click', closeInvoice);
    invoiceModalBackdrop?.addEventListener('click', closeInvoice);
    printInvoice?.addEventListener('click', printSelectedInvoice);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeInvoice();
        }
    });

    loadHistory();
});