<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ngunjuk POS - My Orders</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <main class="app-shell">
    <aside class="sidebar">
      <div class="brand"><span>Ngun</span>juk</div>
      <nav class="nav-menu" aria-label="Menu utama">
        <a class="nav-item" href="index.html"><span class="nav-icon">⌂</span><span>Home page</span></a>
        <a class="nav-item" href="index.html"><span class="nav-icon">▦</span><span>Menu</span></a>
        <a class="nav-item active" href="orders.html"><span class="nav-icon">▱</span><span>My orders</span><small class="badge">13</small></a>
        <a class="nav-item" href="history.html"><span class="nav-icon">◴</span><span>History</span></a>
      </nav>
      <div class="nav-divider"></div>
      <nav class="nav-menu bottom-gap" aria-label="Menu tambahan">
        <a class="nav-item" href="#"><span class="nav-icon">♙</span><span>Partners</span></a>
        <a class="nav-item" href="#"><span class="nav-icon">⚙</span><span>Settings</span></a>
        <a class="nav-item donate" href="#"><span class="donate-dot">♥</span><span>Donate to shelter</span></a>
      </nav>
      <a class="nav-item logout" href="#"><span class="nav-icon">↪</span><span>Log out</span></a>
    </aside>

    <section class="content">
      <header class="topbar">
        <label class="search-box"><span>⌕</span><input type="search" placeholder="Search orders..." autocomplete="off" /></label>
        <button class="filter-btn" type="button">☷ Filter</button>
        <div class="topbar-spacer"></div>
        <a class="cart-toggle page-link-btn" href="index.html"><span class="cart-icon">🛒</span><span>POS Menu</span></a>
        <header class="profile-card">
          <div class="avatar">GS</div>
          <div><strong>Gusti Sardana</strong><p>kasir@ngunjuk.id</p></div>
          <button class="more-btn" type="button">⋮</button>
        </header>
      </header>

      <section class="history-area">
        <div class="history-head">
          <div>
            <span class="eyebrow">Pesanan Aktif</span>
            <h1>My Orders</h1>
            <p>Halaman ini disiapkan untuk menampilkan pesanan yang sedang diproses.</p>
          </div>
        </div>
        <div class="cart-empty">Belum ada pesanan aktif. Silakan input transaksi dari halaman POS Menu.</div>
      </section>
    </section>
  </main>
</body>
</html>
