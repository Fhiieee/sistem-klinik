@php
    $role = auth()->user()->role ?? '';

    $roleLabel = 'User';
    $defaultTitle = 'Dashboard';
    $defaultSubtitle = 'Selamat datang di Klinik Sehati';
    $profileRoute = '#';
    $profileText = 'Profil';

    if ($role === 'admin') {
        $roleLabel = 'Admin';
        $defaultTitle = 'Dashboard Admin';
        $defaultSubtitle = 'Selamat datang, Admin Klinik';
        $profileRoute = Route::has('admin.profile') ? route('admin.profile') : '#';
        $profileText = 'Profil Admin';
    } elseif ($role === 'dokter') {
        $roleLabel = 'Dokter';
        $defaultTitle = 'Dashboard Dokter';
        $defaultSubtitle = 'Selamat datang, Dokter Klinik';
        $profileRoute = Route::has('dokter.profile') ? route('dokter.profile') : '#';
        $profileText = 'Profil Dokter';
    } elseif ($role === 'pasien') {
        $roleLabel = 'Pasien';
        $defaultTitle = 'Dashboard Pasien';
        $defaultSubtitle = 'Selamat datang, Pasien Klinik';
        $profileRoute = Route::has('pasien.profile') ? route('pasien.profile') : '#';
        $profileText = 'Profil Pasien';
    }
@endphp

<header class="topbar">
    <div class="hamburger" onclick="toggleSidebar()">
        <svg viewBox="0 0 64 64">
            <path d="M14 20h36M14 32h36M14 44h36"></path>
        </svg>
    </div>

    <div class="header-title">
        <h1>@yield('page-title', $defaultTitle)</h1>
        <p>@yield('page-subtitle', $defaultSubtitle)</p>
    </div>

    <div class="profile-area">
        <button class="profile-button" type="button" onclick="toggleProfileMenu()">
            <svg viewBox="0 0 64 64">
                <circle cx="32" cy="22" r="12"></circle>
                <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
            </svg>

            <span>{{ $roleLabel }}</span>

            <svg viewBox="0 0 64 64">
                <path d="M18 24l14 16 14-16"></path>
            </svg>
        </button>

        <div class="profile-menu" id="profileMenu">
            <div class="profile-head">
                <div class="profile-avatar-small">
                    <svg viewBox="0 0 64 64">
                        <circle cx="32" cy="22" r="12"></circle>
                        <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                    </svg>
                </div>

                <div>
                    <div class="profile-name">
                        {{ auth()->user()->name ?? $roleLabel }}
                    </div>

                    <div class="profile-email">
                        {{ auth()->user()->email ?? '-' }}
                    </div>
                </div>
            </div>

            <a href="{{ $profileRoute }}" class="profile-link">
                {{ $profileText }}
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="profile-logout">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
