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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- CSS tambahan khusus halaman tertentu --}}
    @yield('extra-css')
</head>

<body class="@yield('body-class')">

    @php
        /*
            layoutType dipakai untuk membedakan halaman:
            - admin  = halaman admin
            - dokter = halaman dokter
            - kosong = halaman auth/login/register biasa
        */
        $layoutType = trim($__env->yieldContent('layout-type', ''));

        /*
            activeMenu dipakai sidebar supaya menu yang sedang aktif bisa menyala.
            Contoh di blade:
            @section('active-menu', 'dashboard')
        */
        $activeMenu = trim($__env->yieldContent('active-menu', ''));

        /*
            Label role untuk topbar/profile.
            Nanti bisa dipakai di components.topbar kalau dibutuhkan.
        */
        $roleLabel = $layoutType === 'dokter' ? 'Dokter' : 'Admin';

        /*
            Route profile dibedakan.
            Kalau dokter belum punya route profile, sementara diarahkan ke dashboard dokter dulu.
        */
        $profileRoute = $layoutType === 'dokter'
            ? (Route::has('dokter.profile') ? route('dokter.profile') : route('dokter.dashboard'))
            : (Route::has('admin.profile') ? route('admin.profile') : route('admin.dashboard'));
    @endphp

    {{-- Layout untuk Admin dan Dokter --}}
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
