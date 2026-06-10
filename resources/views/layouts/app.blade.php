<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @hasSection('title')
            @yield('title')
        @elseif(View::hasSection('page-title'))
            @yield('page-title') - Klinik Sehati
        @else
            Klinik Sehati
        @endif
    </title>

    {{-- CSS utama --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

    {{-- FIX DARURAT SVG GEDE DI RAILWAY --}}
    <style>
        svg {
            width: 24px !important;
            height: 24px !important;
            max-width: 24px !important;
            max-height: 24px !important;
            min-width: 24px !important;
            min-height: 24px !important;
            stroke: #000 !important;
            fill: none !important;
            flex-shrink: 0 !important;
            display: inline-block !important;
        }

        .sidebar svg,
        .topbar svg,
        .profile-button svg,
        .profile-area svg,
        .profile-menu svg,
        .menu-item svg,
        .logout-btn svg,
        .quick-menu-icon svg,
        .quick-menu-item svg,
        .stat-icon svg,
        .card-icon svg,
        .dashboard-card svg,
        .dashboard-icon svg,
        .dashboard-card-icon svg,
        .pendaftaran-form-title-icon svg,
        .dokter-search-box svg,
        .pasien-jadwal-search svg,
        .pasien-pendaftaran-search svg,
        .pasien-riwayat-search svg,
        .data-pasien-search svg,
        .data-dokter-search svg,
        .data-poli-search svg,
        .data-jadwal-content svg,
        .dokter-toolbar svg,
        .dokter-search-box svg,
        .admin-search-box svg,
        .search-box svg,
        .toolbar svg {
            width: 28px !important;
            height: 28px !important;
            max-width: 28px !important;
            max-height: 28px !important;
            min-width: 28px !important;
            min-height: 28px !important;
            stroke: #000 !important;
            fill: none !important;
        }

        .stat-icon svg,
        .card-icon svg,
        .quick-menu-icon svg,
        .pendaftaran-form-title-icon svg,
        .dashboard-card-icon svg {
            width: 34px !important;
            height: 34px !important;
            max-width: 34px !important;
            max-height: 34px !important;
            min-width: 34px !important;
            min-height: 34px !important;
        }

        .sidebar .logo svg,
        .logo svg,
        .brand svg {
            width: auto !important;
            height: auto !important;
            max-width: 80px !important;
            max-height: 80px !important;
        }

        .admin-content svg:not(.allow-large-svg),
        .main svg:not(.allow-large-svg) {
            width: 28px !important;
            height: 28px !important;
            max-width: 28px !important;
            max-height: 28px !important;
            min-width: 28px !important;
            min-height: 28px !important;
        }
    </style>

    {{-- CSS tambahan khusus halaman tertentu --}}
    @yield('extra-css')
</head>

<body class="@yield('body-class')">

    @php
        /*
            layoutType dipakai untuk membedakan halaman:
            - admin  = halaman admin
            - dokter = halaman dokter
            - pasien = halaman pasien
            - kosong = halaman auth/login/register
        */
        $layoutType = trim($__env->yieldContent('layout-type', ''));

        /*
            activeMenu dipakai sidebar supaya menu yang sedang aktif menyala.
            Contoh:
            @section('active-menu', 'dashboard')
        */
        $activeMenu = trim($__env->yieldContent('active-menu', ''));

        /*
            Label role untuk topbar/profile.
        */
        $roleLabel = match ($layoutType) {
            'dokter' => 'Dokter',
            'pasien' => 'Pasien',
            'admin' => 'Admin',
            default => 'User',
        };

        /*
            Route profile dibedakan berdasarkan role.
        */
        $profileRoute = match ($layoutType) {
            'dokter' => Route::has('dokter.profile')
                ? route('dokter.profile')
                : route('dokter.dashboard'),

            'pasien' => Route::has('pasien.profile')
                ? route('pasien.profile')
                : route('pasien.dashboard'),

            'admin' => Route::has('admin.profile')
                ? route('admin.profile')
                : route('admin.dashboard'),

            default => Route::has('login')
                ? route('login')
                : url('/'),
        };
    @endphp

    {{-- Layout untuk Admin, Dokter, dan Pasien --}}
    @if($layoutType === 'admin' || $layoutType === 'dokter' || $layoutType === 'pasien')
        <div class="admin-page">

            {{-- Sidebar --}}
            @include('components.sidebar', [
                'activeMenu' => $activeMenu,
                'layoutType' => $layoutType
            ])

            {{-- Overlay sidebar untuk responsive/mobile --}}
            <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

            <main class="main">

                {{-- Topbar --}}
                @include('components.topbar', [
                    'activeMenu' => $activeMenu,
                    'layoutType' => $layoutType,
                    'roleLabel' => $roleLabel,
                    'profileRoute' => $profileRoute
                ])

                {{-- Isi halaman --}}
                <section class="admin-content">
                    @yield('content')
                </section>
            </main>
        </div>

    {{-- Layout untuk login/register/auth --}}
    @else
        @yield('content')
    @endif

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (sidebar) {
                sidebar.classList.toggle('show');
            }

            if (overlay) {
                overlay.classList.toggle('show');
            }
        }

        function toggleProfileMenu() {
            const profileMenu = document.getElementById('profileMenu');

            if (profileMenu) {
                profileMenu.classList.toggle('show');
            }
        }

        document.addEventListener('click', function(event) {
            const profileArea = document.querySelector('.profile-area');
            const profileMenu = document.getElementById('profileMenu');

            if (profileArea && profileMenu && !profileArea.contains(event.target)) {
                profileMenu.classList.remove('show');
            }
        });
    </script>

    {{-- JS tambahan khusus halaman tertentu --}}
    @yield('extra-js')
</body>
</html>
