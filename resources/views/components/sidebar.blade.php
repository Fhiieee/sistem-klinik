@php
    $activeMenu = View::getSection('active-menu') ?? '';
    $role = auth()->user()->role ?? '';
@endphp

<aside class="sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">
            <svg viewBox="0 0 100 100">
                <path d="M38 8H62V38H92V62H62V92H38V62H8V38H38Z"
                    fill="#8be8b0"
                    stroke="#000"
                    stroke-width="7"
                    stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="brand-title brand-sehati">
            <span class="brand-small">KLINIK</span>
            <span class="brand-big">SEHATI</span>
            <span class="brand-line-mini"></span>
        </div>
    </div>

    <nav class="menu">

        {{-- ================= MENU ADMIN ================= --}}
        @if($role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="menu-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <path d="M8 30L32 10l24 20"></path>
                    <path d="M16 28v26h12V39h8v15h12V28"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.pasien.index') }}" class="menu-link {{ $activeMenu == 'pasien' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <circle cx="32" cy="22" r="12"></circle>
                    <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                </svg>
                Data Pasien
            </a>

            <a href="{{ route('admin.dokter.index') }}" class="menu-link {{ $activeMenu == 'dokter' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <circle cx="32" cy="17" r="10"></circle>
                    <path d="M16 58c3-17 11-27 16-27s13 10 16 27"></path>
                    <path d="M24 36l8 10 8-10"></path>
                    <circle cx="45" cy="50" r="5"></circle>
                </svg>
                Data Dokter
            </a>

            <a href="{{ route('admin.poli.index') }}" class="menu-link {{ $activeMenu == 'poli' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <rect x="14" y="24" width="36" height="30"></rect>
                    <path d="M25 24V12h14v12"></path>
                    <path d="M32 31v12M26 37h12"></path>
                    <path d="M20 54v-8h8v8M36 54v-8h8v8"></path>
                </svg>
                Data Poli
            </a>

            <a href="{{ route('admin.jadwal.index') }}" class="menu-link {{ $activeMenu == 'jadwal' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                    <path d="M20 8v12M44 8v12M10 26h44"></path>
                </svg>
                Jadwal Dokter
            </a>

            <a href="{{ route('admin.pendaftaran.index') }}" class="menu-link {{ $activeMenu == 'pendaftaran' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <rect x="16" y="12" width="34" height="46" rx="3"></rect>
                    <path d="M25 12h16v-4H25z"></path>
                    <path d="M25 29h16M25 39h16M25 49h10"></path>
                </svg>
                Data Pendaftaran
            </a>

            <a href="{{ route('admin.laporan.index') }}" class="menu-link {{ $activeMenu == 'laporan' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <path d="M10 55h44"></path>
                    <rect x="14" y="38" width="7" height="17"></rect>
                    <rect x="28" y="28" width="7" height="27"></rect>
                    <rect x="42" y="17" width="7" height="38"></rect>
                </svg>
                Laporan Pemeriksaan
            </a>
        @endif


        {{-- ================= MENU DOKTER ================= --}}
        @if($role === 'dokter')
            <a href="{{ route('dokter.dashboard') }}" class="menu-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <path d="M8 30L32 10l24 20"></path>
                    <path d="M16 28v26h12V39h8v15h12V28"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('dokter.jadwal.index') }}" class="menu-link {{ $activeMenu == 'jadwal' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                    <path d="M20 8v12M44 8v12M10 26h44"></path>
                </svg>
                Jadwal Saya
            </a>

            <a href="{{ route('dokter.pemeriksaan.index') }}" class="menu-link {{ $activeMenu == 'pemeriksaan' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <rect x="16" y="12" width="34" height="46" rx="3"></rect>
                    <path d="M25 12h16v-4H25z"></path>
                    <path d="M25 29h16M25 39h16M25 49h10"></path>
                </svg>
                Pemeriksaan
            </a>

            <a href="{{ route('dokter.laporan.index') }}" class="menu-link {{ $activeMenu == 'laporan' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <path d="M10 55h44"></path>
                    <rect x="14" y="38" width="7" height="17"></rect>
                    <rect x="28" y="28" width="7" height="27"></rect>
                    <rect x="42" y="17" width="7" height="38"></rect>
                </svg>
                Riwayat Pemeriksaan
            </a>
        @endif


        {{-- ================= MENU PASIEN ================= --}}
        @if($role === 'pasien')
            <a href="{{ route('pasien.dashboard') }}" class="menu-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <path d="M8 30L32 10l24 20"></path>
                    <path d="M16 28v26h12V39h8v15h12V28"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('pasien.jadwal.index') }}" class="menu-link {{ $activeMenu == 'jadwal' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                    <path d="M20 8v12M44 8v12M10 26h44"></path>
                </svg>
                Jadwal Dokter
            </a>

            <a href="{{ route('pasien.pendaftaran.index') }}" class="menu-link {{ $activeMenu == 'pendaftaran' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <rect x="16" y="12" width="34" height="46" rx="3"></rect>
                    <path d="M25 12h16v-4H25z"></path>
                    <path d="M25 29h16M25 39h16M25 49h10"></path>
                </svg>
                Pendaftaran
            </a>

            <a href="{{ route('pasien.riwayat.index') }}" class="menu-link {{ $activeMenu == 'riwayat' ? 'active' : '' }}">
                <svg viewBox="0 0 64 64">
                    <path d="M10 55h44"></path>
                    <rect x="14" y="38" width="7" height="17"></rect>
                    <rect x="28" y="28" width="7" height="27"></rect>
                    <rect x="42" y="17" width="7" height="38"></rect>
                </svg>
                Riwayat Pemeriksaan
            </a>
        @endif

    </nav>

    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="logout-btn">
                <svg viewBox="0 0 64 64">
                    <path d="M26 12H12v40h14"></path>
                    <path d="M30 32h24"></path>
                    <path d="M44 22l10 10-10 10"></path>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>
