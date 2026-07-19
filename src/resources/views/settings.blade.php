<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ngunjuk POS - Settings</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="app-page settings-page">
    <main class="app-shell">
        <aside class="sidebar ng-front-sidebar">
            <div class="brand brand-with-logo">
                <img
                    src="{{ asset('images/ngunjuk-logo.png') }}"
                    alt="Logo Ngunjuk"
                    class="brand-logo"
                >

                <div class="brand-text">
                    <strong><span>Ngu</span>njuk</strong>
                    <small>POS SYSTEM</small>
                </div>
            </div>

            <nav class="nav-menu" aria-label="Menu utama">
                <a class="nav-item" href="{{ route('frontend.home') }}">
                    <span class="nav-icon">⌂</span>
                    <span>Home page</span>
                </a>

                <a class="nav-item" href="{{ route('frontend.history') }}">
                    <span class="nav-icon">◴</span>
                    <span>History</span>
                </a>

                <a class="nav-item active" href="{{ route('frontend.settings') }}">
                    <span class="nav-icon">⚙</span>
                    <span>Settings</span>
                </a>
            </nav>

            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf

                <button class="nav-item logout logout-button" type="submit">
                    <span class="nav-icon">↪</span>
                    <span>Log out</span>
                </button>
            </form>
        </aside>

        <section class="content">
            <header class="topbar">
                <h2>Settings</h2>
                <div class="topbar-spacer"></div>
            </header>

            <section class="settings-area">
                <div class="profile-panel profile-card">
                    <div class="profile-cover"></div>

                    <div class="profile-main profile-header">
                        <div class="avatar profile-avatar" id="profileAvatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div class="profile-identity">
                            <span class="eyebrow">Data Profile</span>
                            <h1 id="profileName">{{ $user->name }}</h1>
                            <p id="profileRole">{{ ucfirst($userRole) }} UMKM Ngunjuk</p>
                        </div>
                    </div>

                    <div class="profile-grid">
                        <div>
                            <span>Nama</span>
                            <strong id="displayName">{{ $user->name }}</strong>
                        </div>

                        <div>
                            <span>Email</span>
                            <strong id="displayEmail">{{ $user->email }}</strong>
                        </div>

                        <div>
                            <span>Role</span>
                            <strong id="displayRole">{{ ucfirst($userRole) }}</strong>
                        </div>

                        <div>
                            <span>Status</span>
                            <strong id="displayStatus">Aktif</strong>
                        </div>
                    </div>
                </div>

                <div class="profile-panel profile-form-panel">
                    <div class="settings-form-head">
                        <span class="eyebrow">Pengaturan Akun</span>
                        <h2>Ubah Password</h2>
                        <p>
                            Masukkan password baru untuk akun Anda. Password minimal 8 karakter
                            serta memiliki huruf besar, huruf kecil, dan angka.
                        </p>
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

                    <form
                        class="settings-form"
                        action="{{ route('frontend.password.update') }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <label for="password">Password Baru</label>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="Masukkan password baru"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        <div class="form-row">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>

                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                placeholder="Ulangi password baru"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        <div class="form-actions">
                            <button class="order-btn" type="submit">
                                Simpan Password Baru
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </main>
</body>
</html>