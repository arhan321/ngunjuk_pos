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
                        <h2>Ubah Data User</h2>
                        <p>
                            Role diambil dari data role Filament/Spatie yang tersedia.
                            Perubahan ini masih hardcode di browser dan belum update database.
                        </p>
                    </div>

                    <form class="settings-form" id="settingsForm">
                        <div class="form-row">
                            <label for="inputName">Nama Lengkap</label>

                            <input
                                id="inputName"
                                type="text"
                                value="{{ $user->name }}"
                                placeholder="Masukkan nama lengkap"
                            >
                        </div>

                        <div class="form-row">
                            <label for="inputEmail">Email</label>

                            <input
                                id="inputEmail"
                                type="email"
                                value="{{ $user->email }}"
                                placeholder="Masukkan email"
                            >
                        </div>

                        <div class="form-row">
                            <label for="inputRole">Role</label>

                            <select id="inputRole">
                                @forelse ($roles as $role)
                                    <option
                                        value="{{ $role->name }}"
                                        @selected($role->name === $userRole)
                                    >
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @empty
                                    <option value="{{ $userRole }}" selected>
                                        {{ ucfirst($userRole) }}
                                    </option>
                                @endforelse
                            </select>
                        </div>

                        <div class="form-row">
                            <label for="inputStatus">Status</label>

                            <select id="inputStatus">
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="form-actions">
                            <button class="order-btn" type="submit">
                                Simpan Perubahan
                            </button>

                            <button class="reset-profile-btn" type="button" id="resetProfile">
                                Reset Data
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </main>

    <div class="toast" id="toast">
        Data profile berhasil diperbarui.
    </div>

    <script>
        const defaultUser = {
            name: @json($user->name),
            email: @json($user->email),
            role: @json($userRole),
            status: 'Aktif'
        };

        const storageKey = 'ngunjuk_profile_settings_user_' + @json($user->id);

        const profileAvatar = document.querySelector('#profileAvatar');
        const profileName = document.querySelector('#profileName');
        const profileRole = document.querySelector('#profileRole');

        const displayName = document.querySelector('#displayName');
        const displayEmail = document.querySelector('#displayEmail');
        const displayRole = document.querySelector('#displayRole');
        const displayStatus = document.querySelector('#displayStatus');

        const inputName = document.querySelector('#inputName');
        const inputEmail = document.querySelector('#inputEmail');
        const inputRole = document.querySelector('#inputRole');
        const inputStatus = document.querySelector('#inputStatus');

        const settingsForm = document.querySelector('#settingsForm');
        const resetProfile = document.querySelector('#resetProfile');
        const toast = document.querySelector('#toast');

        function getInitialName(name) {
            if (!name) {
                return 'U';
            }

            return name.trim().charAt(0).toUpperCase();
        }

        function formatRole(role) {
            if (!role || role === '-') {
                return '-';
            }

            return role.charAt(0).toUpperCase() + role.slice(1);
        }

        function showToast(message) {
            if (!toast) {
                return;
            }

            toast.textContent = message;
            toast.classList.add('show');

            setTimeout(function () {
                toast.classList.remove('show');
            }, 2200);
        }

        function applyProfile(user) {
            profileAvatar.textContent = getInitialName(user.name);
            profileName.textContent = user.name;
            profileRole.textContent = formatRole(user.role) + ' UMKM Ngunjuk';

            displayName.textContent = user.name;
            displayEmail.textContent = user.email;
            displayRole.textContent = formatRole(user.role);
            displayStatus.textContent = user.status;

            inputName.value = user.name;
            inputEmail.value = user.email;
            inputRole.value = user.role;
            inputStatus.value = user.status;
        }

        function getSavedProfile() {
            const savedProfile = localStorage.getItem(storageKey);

            if (!savedProfile) {
                return defaultUser;
            }

            try {
                return {
                    ...defaultUser,
                    ...JSON.parse(savedProfile)
                };
            } catch (error) {
                return defaultUser;
            }
        }

        settingsForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const updatedUser = {
                name: inputName.value.trim() || defaultUser.name,
                email: inputEmail.value.trim() || defaultUser.email,
                role: inputRole.value || defaultUser.role,
                status: inputStatus.value || defaultUser.status
            };

            localStorage.setItem(storageKey, JSON.stringify(updatedUser));
            applyProfile(updatedUser);
            showToast('Data profile berhasil diperbarui sementara.');
        });

        resetProfile.addEventListener('click', function () {
            localStorage.removeItem(storageKey);
            applyProfile(defaultUser);
            showToast('Data profile berhasil direset.');
        });

        applyProfile(getSavedProfile());
    </script>
</body>
</html>
