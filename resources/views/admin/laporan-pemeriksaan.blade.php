@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Laporan Pemeriksaan')
@section('page-subtitle', 'Kelola laporan hasil pemeriksaan pasien')
@section('active-menu', 'laporan')

@section('content')
<div class="data-laporan-content">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="toolbar">
        <div class="search-box">
            <svg viewBox="0 0 64 64">
                <circle cx="27" cy="27" r="16"></circle>
                <path d="M39 39l14 14"></path>
            </svg>

            <input
                type="text"
                id="searchLaporan"
                value="{{ $search ?? '' }}"
                placeholder="Cari laporan pemeriksaan..."
            >
        </div>

        <button type="button" class="search-btn" id="btnSearchLaporan">
            Cari
        </button>
    </div>

    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg viewBox="0 0 64 64">
                    <path d="M10 55h44"></path>
                    <rect x="14" y="38" width="7" height="17"></rect>
                    <rect x="28" y="28" width="7" height="27"></rect>
                    <rect x="42" y="17" width="7" height="38"></rect>
                </svg>
            </div>

            <div>
                <div class="stat-label">Total Pemeriksaan</div>
                <div class="stat-number text-green">{{ $totalPemeriksaan ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <svg viewBox="0 0 64 64">
                    <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                    <path d="M20 8v12M44 8v12M10 26h44"></path>
                    <path d="M24 40l6 6 12-14"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Pemeriksaan Hari Ini</div>
                <div class="stat-number text-blue">{{ $pemeriksaanHariIni ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg viewBox="0 0 64 64">
                    <circle cx="32" cy="22" r="12"></circle>
                    <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Pasien Diperiksa</div>
                <div class="stat-number text-yellow">{{ $totalPasienDiperiksa ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>
    </div>

    <div class="laporan-panel">
        <div class="panel-title">Daftar Laporan Pemeriksaan</div>

        <div class="laporan-table-wrap">
            <table class="laporan-table">
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>Diagnosa</th>
                        <th>Resep</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="laporanTableBody">
                    @include('admin.partials.laporan-table', ['pemeriksaans' => $pemeriksaans])
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchLaporanInput = document.getElementById('searchLaporan');
        const searchLaporanButton = document.getElementById('btnSearchLaporan');
        const laporanTableBody = document.getElementById('laporanTableBody');

        let laporanSearchTimer = null;

        function searchLaporan() {
            const keyword = searchLaporanInput.value;

            laporanTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="empty">Memuat data laporan pemeriksaan...</td>
                </tr>
            `;

            fetch(`{{ route('admin.laporan.ajax.search') }}?search=${encodeURIComponent(keyword)}`, {
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
                    laporanTableBody.innerHTML = data.html;
                } else {
                    laporanTableBody.innerHTML = `
                        <tr>
                            <td colspan="7" class="empty">Gagal memuat data laporan pemeriksaan</td>
                        </tr>
                    `;
                }
            })
            .catch(function () {
                laporanTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="empty">Terjadi kesalahan saat mencari data</td>
                    </tr>
                `;
            });
        }

        if (searchLaporanButton) {
            searchLaporanButton.addEventListener('click', searchLaporan);
        }

        if (searchLaporanInput) {
            searchLaporanInput.addEventListener('keyup', function () {
                clearTimeout(laporanSearchTimer);

                laporanSearchTimer = setTimeout(function () {
                    searchLaporan();
                }, 400);
            });
        }
    });
</script>
@endsection
