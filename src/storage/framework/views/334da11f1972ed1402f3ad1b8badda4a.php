<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <title>Ngunjuk POS - History</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  >

  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">


    <style>
        /* =========================================================
           RESPONSIVE HEADER LOCK - HISTORY & SETTINGS
           Dipasang langsung di Blade agar tidak kalah oleh CSS lama.
           Target: tablet/iPad mengikuti tampilan Home page:
           logo + menu + logout tetap satu baris dalam satu widget.
        ========================================================= */
        @media (min-width: 641px) and (max-width: 1180px) {
            body.history-page,
            body.settings-page {
                width: 100% !important;
                min-height: 100dvh !important;
                padding: 0 !important;
                overflow: auto !important;
            }

            body.history-page .app-shell,
            body.settings-page .app-shell,
            body.history-page .app-shell:not(.single-content),
            body.settings-page .app-shell:not(.single-content),
            body.history-page .app-shell.single-content,
            body.settings-page .app-shell.single-content {
                width: 100% !important;
                height: auto !important;
                min-height: 100dvh !important;
                display: grid !important;
                grid-template-columns: 1fr !important;
                grid-template-rows: auto minmax(0, 1fr) !important;
                gap: 14px !important;
                padding: 14px !important;
                overflow: visible !important;
            }

            body.history-page .sidebar,
            body.settings-page .sidebar {
                position: relative !important;
                width: 100% !important;
                height: auto !important;
                min-height: 0 !important;
                max-height: none !important;
                display: grid !important;
                grid-template-columns: 180px minmax(0, 1fr) 118px !important;
                grid-template-areas: "brand nav logout" !important;
                align-items: center !important;
                gap: 12px !important;
                padding: 14px 16px !important;
                margin: 0 !important;
                border-radius: 24px !important;
                overflow: hidden !important;
            }

            body.history-page .brand,
            body.history-page .brand.brand-with-logo,
            body.settings-page .brand,
            body.settings-page .brand.brand-with-logo {
                grid-area: brand !important;
                width: 100% !important;
                max-width: 180px !important;
                min-width: 0 !important;
                height: 58px !important;
                min-height: 58px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: flex-start !important;
                gap: 8px !important;
                padding: 8px 10px !important;
                margin: 0 !important;
                border-radius: 18px !important;
            }

            body.history-page .brand-logo,
            body.settings-page .brand-logo {
                width: 42px !important;
                height: 42px !important;
                min-width: 42px !important;
                flex: 0 0 42px !important;
                border-radius: 14px !important;
            }

            body.history-page .brand-text,
            body.settings-page .brand-text {
                min-width: 0 !important;
                overflow: hidden !important;
            }

            body.history-page .brand strong,
            body.history-page .brand-text strong,
            body.settings-page .brand strong,
            body.settings-page .brand-text strong {
                font-size: 22px !important;
                line-height: 1 !important;
                letter-spacing: -0.8px !important;
                white-space: nowrap !important;
            }

            body.history-page .brand small,
            body.history-page .brand-text small,
            body.settings-page .brand small,
            body.settings-page .brand-text small {
                margin-top: 4px !important;
                font-size: 8.5px !important;
                letter-spacing: 0.16em !important;
                white-space: nowrap !important;
            }

            body.history-page .nav-menu,
            body.settings-page .nav-menu {
                grid-area: nav !important;
                width: 100% !important;
                min-width: 0 !important;
                display: flex !important;
                grid-template-columns: none !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                align-items: center !important;
                justify-content: flex-start !important;
                gap: 10px !important;
                padding: 0 !important;
                margin: 0 !important;
                overflow: hidden !important;
            }

            body.history-page .logout-form,
            body.settings-page .logout-form {
                grid-area: logout !important;
                width: 118px !important;
                min-width: 118px !important;
                margin: 0 !important;
                padding: 0 !important;
                align-self: center !important;
                justify-self: end !important;
            }

            body.history-page .nav-item,
            body.history-page .logout-button,
            body.settings-page .nav-item,
            body.settings-page .logout-button {
                width: auto !important;
                min-width: 0 !important;
                height: 46px !important;
                min-height: 46px !important;
                max-height: 46px !important;
                display: inline-flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 8px !important;
                padding: 0 14px !important;
                margin: 0 !important;
                border-radius: 16px !important;
                font-size: 12px !important;
                line-height: 1 !important;
                text-align: center !important;
                white-space: nowrap !important;
            }

            body.history-page .nav-menu .nav-item,
            body.settings-page .nav-menu .nav-item {
                flex: 1 1 0 !important;
                max-width: 150px !important;
            }

            body.history-page .logout-button,
            body.settings-page .logout-button {
                width: 100% !important;
                padding: 0 12px !important;
            }

            body.history-page .nav-icon,
            body.settings-page .nav-icon {
                width: 18px !important;
                height: 18px !important;
                min-width: 18px !important;
                flex: 0 0 18px !important;
                font-size: 15px !important;
            }

            body.history-page .nav-item.active::after,
            body.settings-page .nav-item.active::after {
                display: none !important;
            }

            body.history-page .content,
            body.settings-page .content,
            body.history-page .app-shell.single-content .content,
            body.settings-page .app-shell.single-content .content {
                width: 100% !important;
                height: auto !important;
                min-height: 0 !important;
                border-radius: 24px !important;
                overflow: visible !important;
            }

            body.history-page .history-area,
            body.settings-page .settings-area {
                height: auto !important;
                min-height: 70vh !important;
                overflow: visible !important;
            }
        }

        @media (min-width: 641px) and (max-width: 780px) {
            body.history-page .sidebar,
            body.settings-page .sidebar {
                grid-template-columns: 168px minmax(0, 1fr) 108px !important;
                gap: 8px !important;
                padding: 12px 14px !important;
            }

            body.history-page .brand,
            body.history-page .brand.brand-with-logo,
            body.settings-page .brand,
            body.settings-page .brand.brand-with-logo {
                max-width: 168px !important;
                height: 56px !important;
                min-height: 56px !important;
            }

            body.history-page .brand-logo,
            body.settings-page .brand-logo {
                width: 40px !important;
                height: 40px !important;
                min-width: 40px !important;
                flex-basis: 40px !important;
            }

            body.history-page .brand strong,
            body.history-page .brand-text strong,
            body.settings-page .brand strong,
            body.settings-page .brand-text strong {
                font-size: 20px !important;
            }

            body.history-page .nav-menu,
            body.settings-page .nav-menu {
                gap: 8px !important;
            }

            body.history-page .nav-item,
            body.history-page .logout-button,
            body.settings-page .nav-item,
            body.settings-page .logout-button {
                height: 44px !important;
                min-height: 44px !important;
                max-height: 44px !important;
                padding: 0 10px !important;
                font-size: 11.2px !important;
                border-radius: 15px !important;
            }

            body.history-page .logout-form,
            body.settings-page .logout-form {
                width: 108px !important;
                min-width: 108px !important;
            }
        }
    </style>

</head>

<body class="history-page">
  <main class="app-shell">
    <aside class="sidebar">
      <div class="brand brand-with-logo">
      <img src="<?php echo e(asset('images/ngunjuk-logo.png')); ?>" alt="Logo Ngunjuk" class="brand-logo">

      <div class="brand-text">
        <strong><span>Ngu</span>njuk</strong>
        <small>POS SYSTEM</small>
      </div>
    </div>
      <nav class="nav-menu" aria-label="Menu utama">
        <a class="nav-item" href="<?php echo e(route('frontend.home')); ?>">
          <span class="nav-icon">⌂</span>
          <span>Home page</span>
        </a>

        <a class="nav-item active" href="<?php echo e(route('frontend.history')); ?>">
          <span class="nav-icon">◴</span>
          <span>History</span>
        </a>

        <a class="nav-item" href="<?php echo e(route('frontend.settings')); ?>">
          <span class="nav-icon">⚙</span>
          <span>Settings</span>
        </a>
      </nav>

      <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
        <?php echo csrf_field(); ?>

        <button class="nav-item logout logout-button" type="submit">
          <span class="nav-icon">↪</span>
          <span>Log out</span>
        </button>
      </form>
    </aside>

    <section class="content">
      <section class="history-area">
        <div class="history-head">
          <div>
            <span class="eyebrow">Riwayat Transaksi</span>
            <h1>History Order</h1>
          </div>

          <button class="export-btn" type="button" id="exportHistory">
            Export Report
          </button>
        </div>

        <div class="history-stats history-stats-daily">
          <article class="stat-card">
            <span>Total Produk Terjual Hari Ini</span>
            <strong id="statProductsSold">0</strong>
          </article>

          <article class="stat-card">
            <span>Total Order Hari Ini</span>
            <strong id="statOrders">0</strong>
          </article>

          <article class="stat-card">
            <span>Total Penjualan Hari Ini</span>
            <strong id="statSales">Rp 0</strong>
          </article>
        </div>

        <div class="history-filter">
          <label class="history-search" for="historySearch">
            <span>⌕</span>
            <input
              id="historySearch"
              type="search"
              placeholder="Cari ID order atau produk..."
              autocomplete="off"
            >
          </label>

          <select id="historyDateFilter" aria-label="Filter tanggal order">
            <option value="today" selected>Order Hari Ini</option>
            <option value="yesterday">Order Kemarin</option>
            <option value="week">Order Minggu Ini</option>
            <option value="month">Order Bulan Ini</option>
            <option value="all">Semua Order</option>
          </select>

          <select id="historySort" aria-label="Sorting order">
            <option value="latest" selected>Terbaru</option>
            <option value="oldest">Terlama</option>
            <option value="highest">Total Terbesar</option>
            <option value="lowest">Total Terkecil</option>
          </select>
        </div>

        <div class="history-table-wrap">
          <table class="history-table">
            <thead>
              <tr>
                <th>ID Order</th>
                <th>Item</th>
                <th>Waktu</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody id="historyBody"></tbody>
          </table>

          <div class="history-pagination" id="historyPagination">
            <button type="button" id="historyPrevPage">
              Sebelumnya
            </button>

            <span id="historyPageInfo">
              Halaman 1 dari 1
            </span>

            <button type="button" id="historyNextPage">
              Berikutnya
            </button>
          </div>
          <div class="cart-empty history-empty" id="historyEmpty">
            Data history tidak ditemukan.
          </div>
        </div>
      </section>
    </section>
  </main>

  <div class="invoice-modal-backdrop" id="invoiceModalBackdrop"></div>

  <section class="invoice-modal" id="invoiceModal" aria-label="Detail order">
    <div class="invoice-modal-card">
      <div class="invoice-modal-head">
        <div>
          <span class="eyebrow">Detail Transaksi</span>
          <p id="invoiceOrderCode">-</p>
        </div>

        <button class="invoice-close-btn" type="button" id="closeInvoiceModal">
          ×
        </button>
      </div>

      <div class="invoice-preview" id="invoicePreview">
        <div class="invoice-brand">
          <h3>Ngunjuk POS</h3>
        </div>

        <div class="invoice-meta">
          <div>
            <span>Order</span>
            <strong id="invoiceCode">-</strong>
          </div>

          <div>
            <span>Waktu</span>
            <strong id="invoiceDate">-</strong>
          </div>

          <div>
            <span>Status</span>
            <strong id="invoiceStatus">-</strong>
          </div>
        </div>

        <div class="invoice-items" id="invoiceItems"></div>

        <div class="invoice-total-box">
          <div>
            <span>Total Item</span>
            <strong id="invoiceTotalItem">0 item</strong>
          </div>

          <div class="invoice-grand-total">
            <span>Total Harga</span>
            <strong id="invoiceTotalPrice">Rp 0</strong>
          </div>
        </div>

        <div class="invoice-footer-note">
          <p>Terima kasih sudah berbelanja di Ngunjuk.</p>
          <small>Simpan struk ini sebagai bukti transaksi.</small>
        </div>
      </div>

      <div class="invoice-actions">
        <button class="invoice-secondary-btn" type="button" id="closeInvoiceModalBottom">
          Tutup
        </button>

        <button class="invoice-print-btn" type="button" id="printInvoice">
          Cetak Struk
        </button>
      </div>
    </div>
  </section>

  <div class="toast" id="toast">
    Data history siap diexport.
  </div>

  <script>
    window.NGUNJUK_ROUTES = {
      home: "<?php echo e(route('frontend.home')); ?>",
      history: "<?php echo e(route('frontend.history')); ?>",
      settings: "<?php echo e(route('frontend.settings')); ?>",
      historyApi: "<?php echo e(route('api.history.list')); ?>"
    };

    window.NGUNJUK_CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
  </script>

  <script src="<?php echo e(asset('js/historyy.js')); ?>"></script>
</body>
</html><?php /**PATH /var/www/html/resources/views/history.blade.php ENDPATH**/ ?>