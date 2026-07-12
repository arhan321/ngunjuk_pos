<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Login - Ngunjuk POS</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet"
  >

  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=login-pos-redesign">
</head>

<body class="pos-login-page">
  <main class="pos-login-shell">
    <section class="pos-login-card">
      <div class="pos-login-left">
        <div class="pos-login-left-content">
          <div class="pos-login-brand-row">
            <div class="pos-login-logo-wrap">
              <img
                src="{{ asset('images/ngunjuk-logo.png') }}"
                alt="Logo Ngunjuk POS"
                class="pos-login-logo"
              >
            </div>

            <div class="pos-login-brand-text">
              <span class="pos-login-line"></span>

              <h1>
                Point of Sale
                <strong>Ngunjuk</strong>
              </h1>
            </div>
          </div>

          <p>
            Kelola transaksi minuman, keranjang pesanan, dan riwayat
            order dalam satu tampilan kasir.
          </p>
        </div>

  
      </div>

      <div class="pos-login-right">
        <div class="pos-login-form-card">
          <div class="pos-login-head">
            <span>Kasir Area</span>
            <h2>Login</h2>
            <p>Masuk menggunakan akun kasir.</p>
          </div>

          @if (session('success'))
            <div class="pos-login-alert success">
              <span>✓</span>
              <p>{{ session('success') }}</p>
            </div>
          @endif

          @if ($errors->any())
            <div class="pos-login-alert error">
              <span>!</span>
              <p>{{ $errors->first() }}</p>
            </div>
          @endif

          <form action="{{ route('login.process') }}" method="POST" class="pos-login-form">
            @csrf

            <label class="pos-login-field">
              <span>Email</span>

              <div class="pos-login-input">
                <i aria-hidden="true">✉</i>

                <input
                  name="email"
                  type="email"
                  placeholder="user@gmail.com"
                  autocomplete="email"
                  value="{{ old('email') }}"
                  required
                >
              </div>
            </label>

            <label class="pos-login-field">
              <span>Password</span>

              <div class="pos-login-input">
                <i aria-hidden="true">🔒</i>

                <input
                  id="loginPassword"
                  name="password"
                  type="password"
                  placeholder="••••••••"
                  autocomplete="current-password"
                  required
                >

                <button
                  class="pos-password-toggle"
                  type="button"
                  aria-label="Tampilkan atau sembunyikan password"
                  onclick="toggleLoginPassword()"
                >
                  👁
                </button>
              </div>
            </label>

            <label class="pos-login-remember">
              <input type="checkbox" name="remember" value="1">
              <span>Ingat saya</span>
            </label>

            <button class="pos-login-submit" type="submit">
              <span>Masuk</span>
              <i aria-hidden="true">→</i>
            </button>
          </form>
        </div>
      </div>
    </section>
  </main>

  <script>
    function toggleLoginPassword() {
      const input = document.getElementById('loginPassword');

      if (!input) {
        return;
      }

      input.type = input.type === 'password' ? 'text' : 'password';
    }
  </script>
</body>
</html>