@extends('layouts.app')

@section('layout-type', 'pasien')
@section('active-menu', 'pendaftaran')

@section('page-title', 'Pendaftaran')
@section('page-subtitle', 'Kelola data pendaftaran pemeriksaan Anda')

@section('content')
<div class="pasien-pendaftaran-content">

    @if(session('success'))
        <div class="pasien-pendaftaran-alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="pasien-pendaftaran-alert error">
            {{ session('error') }}
        </div>
    @endif

    <div class="pasien-pendaftaran-toolbar">
        <div class="pasien-pendaftaran-search">
            <svg viewBox="0 0 64 64">
                <circle cx="27" cy="27" r="16"></circle>
                <path d="M39 39l13 13"></path>
            </svg>

            <input
                type="text"
                id="searchPendaftaranPasien"
                value="{{ $search ?? '' }}"
                placeholder="Cari pendaftaran, dokter, poli, status..."
            >
        </div>

        <button type="button" class="pasien-pendaftaran-search-btn" id="btnSearchPendaftaranPasien">
            Cari
        </button>

        <a href="{{ route('pasien.pendaftaran.create') }}" class="pasien-pendaftaran-add-btn">
            <svg viewBox="0 0 64 64">
                <path d="M32 12v40"></path>
                <path d="M12 32h40"></path>
            </svg>
            Daftar Baru
        </a>
    </div>

    <div class="pasien-pendaftaran-stat-row">
        <div class="pasien-pendaftaran-stat-card">
            <div class="pasien-pendaftaran-stat-icon green">
                <svg viewBox="0 0 64 64">
                    <rect x="16" y="12" width="34" height="46" rx="3"></rect>
                    <path d="M25 12h16v-4H25z"></path>
                    <path d="M25 29h16M25 39h16M25 49h10"></path>
                </svg>
            </div>

            <div>
                <div class="pasien-pendaftaran-stat-label">Total Pendaftaran</div>
                <div class="pasien-pendaftaran-stat-number text-green">
                    {{ $totalPendaftaran ?? 0 }}
                </div>
            </div>

            <div class="pasien-pendaftaran-card-dots">...</div>
        </div>

        <div class="pasien-pendaftaran-stat-card">
            <div class="pasien-pendaftaran-stat-icon yellow">
                <svg viewBox="0 0 64 64">
                    <circle cx="32" cy="32" r="22"></circle>
                    <path d="M32 18v16l10 7"></path>
                </svg>
            </div>

            <div>
                <div class="pasien-pendaftaran-stat-label">Menunggu</div>
                <div class="pasien-pendaftaran-stat-number text-yellow">
                    {{ $pendaftaranMenunggu ?? 0 }}
                </div>
            </div>

            <div class="pasien-pendaftaran-card-dots">...</div>
        </div>

        <div class="pasien-pendaftaran-stat-card">
            <div class="pasien-pendaftaran-stat-icon blue">
                <svg viewBox="0 0 64 64">
                    <rect x="14" y="14" width="36" height="40" rx="3"></rect>
                    <path d="M24 29l6 6 12-13"></path>
                    <path d="M22 44h20"></path>
                </svg>
            </div>

            <div>
                <div class="pasien-pendaftaran-stat-label">Selesai</div>
                <div class="pasien-pendaftaran-stat-number text-blue">
                    {{ $pendaftaranSelesai ?? 0 }}
                </div>
            </div>

            <div class="pasien-pendaftaran-card-dots">...</div>
        </div>
    </div>

    <div class="pasien-pendaftaran-panel">
        <div class="pasien-pendaftaran-panel-title">
            Daftar Pendaftaran Saya
        </div>

        <div class="pasien-pendaftaran-table-wrap">
            <table class="pasien-pendaftaran-table">
                <thead>
                    <tr>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>Hari</th>
                        <th>Tanggal Daftar</th>
                        <th>No. Antrean</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody id="pendaftaranPasienTableBody">
                    @include('pasien.partials.pendaftaran-table', ['pendaftarans' => $pendaftarans])
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchPendaftaranPasien');
        const searchButton = document.getElementById('btnSearchPendaftaranPasien');
        const tableBody = document.getElementById('pendaftaranPasienTableBody');

        let searchTimer = null;

        function searchPendaftaranPasien() {
            const keyword = searchInput.value;

            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="pasien-pendaftaran-empty">
                        Memuat data pendaftaran...
                    </td>
                </tr>
            `;

            fetch(`{{ route('pasien.pendaftaran.ajax.search') }}?search=${encodeURIComponent(keyword)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.status === 'success') {
                    tableBody.innerHTML = data.html;
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="pasien-pendaftaran-empty">
                                Gagal memuat data pendaftaran
                            </td>
                        </tr>
                    `;
                }
            })
            .catch(function () {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="pasien-pendaftaran-empty">
                            Terjadi kesalahan saat mencari data
                        </td>
                    </tr>
                `;
            });
        }

        if (searchButton) {
            searchButton.addEventListener('click', searchPendaftaranPasien);
        }

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(searchPendaftaranPasien, 400);
            });
        }
    });
</script>
@endsection
