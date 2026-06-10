@extends('layouts.app')

@section('layout-type', 'pasien')
@section('active-menu', 'riwayat')

@section('page-title', 'Riwayat Pemeriksaan')
@section('page-subtitle', 'Lihat hasil pemeriksaan kesehatan Anda')

@section('content')
<div class="pasien-riwayat-content">

    <div class="pasien-riwayat-toolbar">
        <div class="pasien-riwayat-search">
            <svg viewBox="0 0 64 64">
                <circle cx="27" cy="27" r="16"></circle>
                <path d="M39 39l13 13"></path>
            </svg>

            <input
                type="text"
                id="searchRiwayatPasien"
                value="{{ $search ?? '' }}"
                placeholder="Cari dokter, poli, diagnosa, resep..."
            >
        </div>

        <button type="button" class="pasien-riwayat-search-btn" id="btnSearchRiwayatPasien">
            Cari
        </button>
    </div>

    <div class="pasien-riwayat-stat-row">
        <div class="pasien-riwayat-stat-card">
            <div class="pasien-riwayat-stat-icon green">
                <svg viewBox="0 0 64 64">
                    <path d="M10 55h44"></path>
                    <rect x="14" y="38" width="7" height="17"></rect>
                    <rect x="28" y="28" width="7" height="27"></rect>
                    <rect x="42" y="17" width="7" height="38"></rect>
                </svg>
            </div>

            <div>
                <div class="pasien-riwayat-stat-label">Total Pemeriksaan</div>
                <div class="pasien-riwayat-stat-number text-green">
                    {{ $totalPemeriksaan ?? 0 }}
                </div>
            </div>

            <div class="pasien-riwayat-card-dots">...</div>
        </div>

        <div class="pasien-riwayat-stat-card">
            <div class="pasien-riwayat-stat-icon blue">
                <svg viewBox="0 0 64 64">
                    <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                    <path d="M20 8v12M44 8v12M10 26h44"></path>
                    <path d="M24 40l6 6 12-14"></path>
                </svg>
            </div>

            <div>
                <div class="pasien-riwayat-stat-label">Hari Ini</div>
                <div class="pasien-riwayat-stat-number text-blue">
                    {{ $pemeriksaanHariIni ?? 0 }}
                </div>
            </div>

            <div class="pasien-riwayat-card-dots">...</div>
        </div>

        <div class="pasien-riwayat-stat-card">
            <div class="pasien-riwayat-stat-icon yellow">
                <svg viewBox="0 0 64 64">
                    <rect x="16" y="12" width="34" height="46" rx="3"></rect>
                    <path d="M25 12h16v-4H25z"></path>
                    <path d="M25 29h16M25 39h16M25 49h10"></path>
                </svg>
            </div>

            <div>
                <div class="pasien-riwayat-stat-label">Total Pendaftaran</div>
                <div class="pasien-riwayat-stat-number text-yellow">
                    {{ $totalPendaftaran ?? 0 }}
                </div>
            </div>

            <div class="pasien-riwayat-card-dots">...</div>
        </div>
    </div>

    <div class="pasien-riwayat-panel">
        <div class="pasien-riwayat-panel-title">
            Daftar Riwayat Pemeriksaan
        </div>

        <div class="pasien-riwayat-table-wrap">
            <table class="pasien-riwayat-table">
                <thead>
                    <tr>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>Keluhan</th>
                        <th>Diagnosa</th>
                        <th>Resep</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody id="riwayatPasienTableBody">
                    @include('pasien.partials.riwayat-table', ['pemeriksaans' => $pemeriksaans])
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchRiwayatPasien');
        const searchButton = document.getElementById('btnSearchRiwayatPasien');
        const tableBody = document.getElementById('riwayatPasienTableBody');

        let searchTimer = null;

        function searchRiwayatPasien() {
            const keyword = searchInput.value;

            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="pasien-riwayat-empty">
                        Memuat data riwayat pemeriksaan...
                    </td>
                </tr>
            `;

            fetch(`{{ route('pasien.riwayat.ajax.search') }}?search=${encodeURIComponent(keyword)}`, {
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
                            <td colspan="6" class="pasien-riwayat-empty">
                                Gagal memuat data riwayat pemeriksaan
                            </td>
                        </tr>
                    `;
                }
            })
            .catch(function () {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="pasien-riwayat-empty">
                            Terjadi kesalahan saat mencari data
                        </td>
                    </tr>
                `;
            });
        }

        if (searchButton) {
            searchButton.addEventListener('click', searchRiwayatPasien);
        }

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(searchRiwayatPasien, 400);
            });
        }
    });
</script>
@endsection
