<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <title>Ngunjuk POS - Kasir</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  >

  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">

  <style id="ng-front-sidebar-sync">
    /* =========================================================
       FRONTEND SIDEBAR WIDGET SYNC
       Home, History, Settings memakai widget menu yang sama.
       Tidak perlu membuat file partial baru.
    ========================================================= */

    @media (min-width: 561px) and (max-width: 1180px) {
      body:has(.ng-front-sidebar),
      body.history-page,
      body.settings-page {
        width: 100% !important;
        min-height: 100dvh !important;
        overflow-x: hidden !important;
        overflow-y: auto !important;
      }

      body:has(.ng-front-sidebar) .app-shell,
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
        gap: 16px !important;

        padding: 18px 22px 28px !important;
        overflow: visible !important;
      }

      body .ng-front-sidebar,
      body.history-page .ng-front-sidebar,
      body.settings-page .ng-front-sidebar {
        position: relative !important;
        left: auto !important;
        right: auto !important;
        top: auto !important;
        bottom: auto !important;

        width: 100% !important;
        height: auto !important;
        min-height: 86px !important;
        max-height: none !important;

        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: flex-start !important;
        gap: 12px !important;

        padding: 13px 16px !important;
        margin: 0 !important;

        border-radius: 26px !important;
        overflow: hidden !important;
      }

      body .ng-front-sidebar .brand,
      body .ng-front-sidebar .brand.brand-with-logo,
      body.history-page .ng-front-sidebar .brand,
      body.history-page .ng-front-sidebar .brand.brand-with-logo,
      body.settings-page .ng-front-sidebar .brand,
      body.settings-page .ng-front-sidebar .brand.brand-with-logo {
        flex: 0 0 190px !important;
        width: 190px !important;
        min-width: 190px !important;
        max-width: 190px !important;

        height: 62px !important;
        min-height: 62px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        gap: 8px !important;

        padding: 8px 12px !important;
        margin: 0 !important;

        border-radius: 18px !important;
      }

      body .ng-front-sidebar .brand-logo,
      body.history-page .ng-front-sidebar .brand-logo,
      body.settings-page .ng-front-sidebar .brand-logo {
        width: 40px !important;
        height: 40px !important;
        min-width: 40px !important;
        flex: 0 0 40px !important;
        border-radius: 14px !important;
      }

      body .ng-front-sidebar .brand-text,
      body.history-page .ng-front-sidebar .brand-text,
      body.settings-page .ng-front-sidebar .brand-text {
        min-width: 0 !important;
        overflow: hidden !important;
      }

      body .ng-front-sidebar .brand strong,
      body .ng-front-sidebar .brand-text strong,
      body.history-page .ng-front-sidebar .brand strong,
      body.history-page .ng-front-sidebar .brand-text strong,
      body.settings-page .ng-front-sidebar .brand strong,
      body.settings-page .ng-front-sidebar .brand-text strong {
        font-size: 21px !important;
        line-height: 1 !important;
        letter-spacing: -0.8px !important;
        white-space: nowrap !important;
      }

      body .ng-front-sidebar .brand small,
      body .ng-front-sidebar .brand-text small,
      body.history-page .ng-front-sidebar .brand small,
      body.history-page .ng-front-sidebar .brand-text small,
      body.settings-page .ng-front-sidebar .brand small,
      body.settings-page .ng-front-sidebar .brand-text small {
        margin-top: 5px !important;
        font-size: 8px !important;
        letter-spacing: 0.16em !important;
        white-space: nowrap !important;
      }

      body .ng-front-sidebar .nav-menu,
      body.history-page .ng-front-sidebar .nav-menu,
      body.settings-page .ng-front-sidebar .nav-menu {
        flex: 0 0 auto !important;
        width: auto !important;
        min-width: 0 !important;
        max-width: none !important;

        display: flex !important;
        grid-template-columns: none !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        justify-content: flex-start !important;
        gap: 9px !important;

        padding: 0 !important;
        margin: 0 !important;
        overflow: visible !important;
      }

      body .ng-front-sidebar .nav-menu > .nav-item,
      body.history-page .ng-front-sidebar .nav-menu > .nav-item,
      body.settings-page .ng-front-sidebar .nav-menu > .nav-item,
      body .ng-front-sidebar .logout-button,
      body.history-page .ng-front-sidebar .logout-button,
      body.settings-page .ng-front-sidebar .logout-button {
        flex: 0 0 auto !important;

        width: auto !important;
        min-width: 0 !important;
        max-width: none !important;

        height: 42px !important;
        min-height: 42px !important;
        max-height: 42px !important;

        display: inline-flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;

        padding: 0 13px !important;
        margin: 0 !important;

        border-radius: 15px !important;

        font-size: 11px !important;
        font-weight: 900 !important;
        line-height: 1 !important;
        text-align: center !important;
        white-space: nowrap !important;
      }

      body .ng-front-sidebar .logout-form,
      body.history-page .ng-front-sidebar .logout-form,
      body.settings-page .ng-front-sidebar .logout-form {
        flex: 0 0 auto !important;
        width: auto !important;
        min-width: 0 !important;
        max-width: none !important;

        margin: 0 0 0 auto !important;
        padding: 0 !important;

        align-self: center !important;
      }

      body .ng-front-sidebar .logout-button,
      body.history-page .ng-front-sidebar .logout-button,
      body.settings-page .ng-front-sidebar .logout-button {
        padding: 0 15px !important;
      }

      body .ng-front-sidebar .nav-icon,
      body.history-page .ng-front-sidebar .nav-icon,
      body.settings-page .ng-front-sidebar .nav-icon {
        width: 14px !important;
        height: 14px !important;
        min-width: 14px !important;
        flex: 0 0 14px !important;
        font-size: 12px !important;
      }

      body .ng-front-sidebar .nav-item.active::after,
      body.history-page .ng-front-sidebar .nav-item.active::after,
      body.settings-page .ng-front-sidebar .nav-item.active::after {
        display: none !important;
      }

      body:has(.ng-front-sidebar) .content,
      body.history-page .content,
      body.settings-page .content,
      body.history-page .app-shell.single-content .content,
      body.settings-page .app-shell.single-content .content {
        width: 100% !important;
        height: auto !important;
        min-height: 0 !important;
        border-radius: 26px !important;
        overflow: visible !important;
      }

      body.settings-page .topbar {
        display: none !important;
      }

      body.history-page .history-area,
      body.settings-page .settings-area {
        height: auto !important;
        min-height: 70vh !important;
        overflow: visible !important;
      }
    }

    @media (min-width: 561px) and (max-width: 780px) {
      body .ng-front-sidebar,
      body.history-page .ng-front-sidebar,
      body.settings-page .ng-front-sidebar {
        min-height: 80px !important;
        gap: 8px !important;
        padding: 12px 14px !important;
      }

      body .ng-front-sidebar .brand,
      body .ng-front-sidebar .brand.brand-with-logo,
      body.history-page .ng-front-sidebar .brand,
      body.history-page .ng-front-sidebar .brand.brand-with-logo,
      body.settings-page .ng-front-sidebar .brand,
      body.settings-page .ng-front-sidebar .brand.brand-with-logo {
        flex-basis: 168px !important;
        width: 168px !important;
        min-width: 168px !important;
        max-width: 168px !important;

        height: 56px !important;
        min-height: 56px !important;
      }

      body .ng-front-sidebar .brand-logo,
      body.history-page .ng-front-sidebar .brand-logo,
      body.settings-page .ng-front-sidebar .brand-logo {
        width: 38px !important;
        height: 38px !important;
        min-width: 38px !important;
        flex-basis: 38px !important;
      }

      body .ng-front-sidebar .brand strong,
      body .ng-front-sidebar .brand-text strong,
      body.history-page .ng-front-sidebar .brand strong,
      body.history-page .ng-front-sidebar .brand-text strong,
      body.settings-page .ng-front-sidebar .brand strong,
      body.settings-page .ng-front-sidebar .brand-text strong {
        font-size: 20px !important;
      }

      body .ng-front-sidebar .nav-menu,
      body.history-page .ng-front-sidebar .nav-menu,
      body.settings-page .ng-front-sidebar .nav-menu {
        gap: 7px !important;
      }

      body .ng-front-sidebar .nav-menu > .nav-item,
      body.history-page .ng-front-sidebar .nav-menu > .nav-item,
      body.settings-page .ng-front-sidebar .nav-menu > .nav-item,
      body .ng-front-sidebar .logout-button,
      body.history-page .ng-front-sidebar .logout-button,
      body.settings-page .ng-front-sidebar .logout-button {
        height: 40px !important;
        min-height: 40px !important;
        max-height: 40px !important;

        padding: 0 10px !important;
        border-radius: 14px !important;

        font-size: 10.5px !important;
        gap: 5px !important;
      }

      body .ng-front-sidebar .logout-button,
      body.history-page .ng-front-sidebar .logout-button,
      body.settings-page .ng-front-sidebar .logout-button {
        padding: 0 12px !important;
      }
    }

    @media (max-width: 560px) {
      body:has(.ng-front-sidebar),
      body.history-page,
      body.settings-page {
        height: auto !important;
        min-height: 100dvh !important;
        overflow-x: hidden !important;
        overflow-y: auto !important;
      }

      body:has(.ng-front-sidebar) .app-shell,
      body.history-page .app-shell,
      body.settings-page .app-shell,
      body.history-page .app-shell:not(.single-content),
      body.settings-page .app-shell:not(.single-content) {
        width: 100% !important;
        min-height: 100dvh !important;
        height: auto !important;

        display: block !important;

        padding: 10px 10px 92px !important;
        overflow: visible !important;
      }

      body .ng-front-sidebar,
      body.history-page .ng-front-sidebar,
      body.settings-page .ng-front-sidebar {
        position: fixed !important;
        left: 10px !important;
        right: 10px !important;
        bottom: 10px !important;
        top: auto !important;

        width: auto !important;
        height: 68px !important;
        min-height: 68px !important;
        max-height: 68px !important;

        z-index: 9999 !important;

        display: grid !important;
        grid-template-columns: minmax(0, 1fr) 58px !important;
        align-items: center !important;
        gap: 8px !important;

        padding: 8px !important;
        margin: 0 !important;

        border-radius: 24px !important;
        overflow: hidden !important;
      }

      body .ng-front-sidebar .brand,
      body .ng-front-sidebar .brand.brand-with-logo,
      body.history-page .ng-front-sidebar .brand,
      body.history-page .ng-front-sidebar .brand.brand-with-logo,
      body.settings-page .ng-front-sidebar .brand,
      body.settings-page .ng-front-sidebar .brand.brand-with-logo {
        display: none !important;
      }

      body .ng-front-sidebar .nav-menu,
      body.history-page .ng-front-sidebar .nav-menu,
      body.settings-page .ng-front-sidebar .nav-menu {
        width: 100% !important;
        min-width: 0 !important;

        display: grid !important;
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 6px !important;

        margin: 0 !important;
        padding: 0 !important;
      }

      body .ng-front-sidebar .nav-menu > .nav-item,
      body.history-page .ng-front-sidebar .nav-menu > .nav-item,
      body.settings-page .ng-front-sidebar .nav-menu > .nav-item,
      body .ng-front-sidebar .logout-button,
      body.history-page .ng-front-sidebar .logout-button,
      body.settings-page .ng-front-sidebar .logout-button {
        width: 100% !important;
        min-width: 0 !important;
        max-width: 100% !important;

        height: 52px !important;
        min-height: 52px !important;
        max-height: 52px !important;

        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 3px !important;

        padding: 0 4px !important;
        margin: 0 !important;

        border-radius: 18px !important;

        font-size: 9px !important;
        line-height: 1 !important;
        text-align: center !important;
        white-space: nowrap !important;
      }

      body .ng-front-sidebar .logout-form,
      body.history-page .ng-front-sidebar .logout-form,
      body.settings-page .ng-front-sidebar .logout-form {
        width: 58px !important;
        min-width: 58px !important;
        max-width: 58px !important;
        margin: 0 !important;
        padding: 0 !important;
      }

      body .ng-front-sidebar .logout-button span:last-child,
      body.history-page .ng-front-sidebar .logout-button span:last-child,
      body.settings-page .ng-front-sidebar .logout-button span:last-child {
        display: none !important;
      }

      body .ng-front-sidebar .nav-icon,
      body.history-page .ng-front-sidebar .nav-icon,
      body.settings-page .ng-front-sidebar .nav-icon {
        width: 18px !important;
        height: 18px !important;
        flex: 0 0 auto !important;
        font-size: 15px !important;
      }

      body .ng-front-sidebar .nav-item.active::after,
      body.history-page .ng-front-sidebar .nav-item.active::after,
      body.settings-page .ng-front-sidebar .nav-item.active::after {
        display: none !important;
      }
    }
  </style>

</head>

<body>
  <main class="app-shell">
    <aside class="sidebar ng-front-sidebar">
      <div class="brand brand-with-logo">
        <img src="<?php echo e(asset('images/ngunjuk-logo.png')); ?>" alt="Logo Ngunjuk" class="brand-logo">

        <div class="brand-text">
          <strong><span>Ngu</span>njuk</strong>
          <small>POS SYSTEM</small>
        </div>
      </div>

      <nav class="nav-menu" aria-label="Menu utama">
        <a class="nav-item active" href="<?php echo e(route('frontend.home')); ?>">
          <span class="nav-icon">⌂</span>
          <span>Home page</span>
        </a>

        <a class="nav-item" href="<?php echo e(route('frontend.history')); ?>">
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
      <header class="topbar">
        <label class="search-box" for="searchInput">
          <span>⌕</span>
          <input
            id="searchInput"
            type="search"
            placeholder="Search menu..."
            autocomplete="off"
          >
        </label>

        <div class="topbar-spacer"></div>

        <button class="cart-toggle" id="openCart" type="button">
          <span>🛒</span>
          Cart
          <small id="cartCount">0</small>
        </button>

        <a class="profile-mini" href="<?php echo e(route('frontend.settings')); ?>">
          <div class="avatar">
            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

          </div>

          <div>
            <strong><?php echo e(auth()->user()->name); ?></strong>
            <p><?php echo e(auth()->user()->email); ?></p>
          </div>
        </a>
      </header>

      <section class="menu-area abstract-area pos-luxury-area">
        <div class="category-tabs luxury-category-tabs" id="categoryTabs"></div>

        <h1 id="menuTitle" class="sr-only">Coffee menu</h1>

        <div class="product-grid luxury-product-grid" id="productGrid"></div>
      </section>
    </section>
  </main>

  <div class="cart-backdrop" id="cartBackdrop"></div>

  <aside class="cart-drawer" id="cartDrawer" aria-label="Keranjang pesanan">
    <div class="cart-drawer-head">
      <div>
        <h2>Keranjang</h2>
        <span id="orderCode">Order baru</span>
      </div>

      <button class="close-cart" id="closeCart" type="button">
        ×
      </button>
    </div>

    <div class="cart-list" id="cartList"></div>

    <div class="summary">
      <div>
        <span>Items</span>
        <strong id="itemsTotal">Rp 0</strong>
      </div>

      <div class="summary-total">
        <span>Total</span>
        <strong id="grandTotal">Rp 0</strong>
      </div>
    </div>

    <button class="order-btn" id="placeOrder" type="button">
      Place an order
    </button>
  </aside>

  <div class="checkout-success-backdrop" id="checkoutSuccessBackdrop"></div>

  <section class="checkout-success-modal" id="checkoutSuccessModal" aria-label="Order berhasil">
    <div class="checkout-success-card">
      <div class="success-icon-wrap">
        <div class="success-icon">✓</div>
      </div>

      <span class="success-eyebrow">Transaksi Berhasil</span>

      <div class="success-order-box">
        <div>
          <span>Kode Order</span>
          <strong id="successOrderCode">-</strong>
        </div>
      </div>

      <div class="success-order-items" id="successOrderItems"></div>

      <div class="success-order-box">
        <div>
          <span>Total Item</span>
          <strong id="successTotalItem">0 item</strong>
        </div>

        <div class="success-total-row">
          <span>Total Harga</span>
          <strong id="successTotalPrice">Rp 0</strong>
        </div>
      </div>

      <div class="success-actions success-actions-three">
        <button class="success-secondary-btn" type="button" id="successStayPos">
          Kembali ke POS
        </button>

        <button class="success-print-btn" type="button" id="successPrintReceipt">
          Cetak Struk
        </button>

        <button class="success-primary-btn" type="button" id="successGoHistory">
          Lihat History
        </button>
      </div>
    </div>
  </section>

  <div class="checkout-confirm-backdrop" id="checkoutConfirmBackdrop"></div>

  <section class="checkout-confirm-modal" id="checkoutConfirmModal" aria-label="Konfirmasi order">
    <div class="checkout-confirm-card">
      <div class="confirm-icon-wrap">
        <div class="confirm-icon">?</div>
      </div>

      <span class="confirm-eyebrow">Konfirmasi Order</span>

      <div class="confirm-order-items" id="confirmOrderItems"></div>

      <div class="confirm-order-box">
        <div>
          <span>Total Item</span>
          <strong id="confirmTotalItem">0 item</strong>
        </div>

        <div class="confirm-total-row">
          <span>Total Harga</span>
          <strong id="confirmTotalPrice">Rp 0</strong>
        </div>
      </div>

      <div class="confirm-actions">
        <button class="confirm-secondary-btn" type="button" id="cancelCheckout">
          Batal
        </button>

        <button class="confirm-primary-btn" type="button" id="confirmCheckout">
          Konfirmasi Order
        </button>
      </div>
    </div>
  </section>

  <div class="toast" id="toast">
    Transaksi berhasil disimpan.
  </div>

  <script>
    window.NGUNJUK_ROUTES = {
      products: "<?php echo e(route('api.products.list')); ?>",
      orders: "<?php echo e(route('api.orders.store')); ?>",
      history: "<?php echo e(route('frontend.history')); ?>",
      storage: "<?php echo e(asset('storage')); ?>"
    };

    window.NGUNJUK_CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
  </script>

  <script src="<?php echo e(asset('js/script.js')); ?>"></script>
</body>
</html><?php /**PATH /var/www/html/resources/views/index.blade.php ENDPATH**/ ?>