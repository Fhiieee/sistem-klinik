@extends('layouts.app')
@section('layout-type', 'dokter')

@section('page-title', 'Riwayat Pemeriksaan')
@section('page-subtitle', 'Lihat riwayat pemeriksaan yang sudah dilakukan')
@section('active-menu', 'laporan')

@section('content')
<div class="dokter-pemeriksaan-content">

    @if(session('success'))
        <div class="dokter-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="dokter-alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="dokter-toolbar">
        <div class="dokter-search-box">
            <svg viewBox="0 0 64 64">
                <circle cx="27" cy="27" r="16"></circle>
                <path d="M39 39l14 14"></path>
            </svg>

            <input
                type="text"
                id="searchLaporanDokter"
                value="{{ $search ?? '' }}"
                placeholder="Cari pasien, diagnosa, resep..."
            >
        </div>

        <button type="button" class="dokter-search-btn" id="btnSearchLaporanDokter">
            Cari
        </button>
    </div>

    <div class="dokter-panel">
        <div class="dokter-panel-title">Riwayat Pemeriksaan</div>

        <div class="dokter-table-wrap">
            <table class="dokter-table">
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>Poli</th>
                        <th>Keluhan</th>
                        <th>Diagnosa</th>
                        <th>Resep</th>
                    </tr>
                </thead>

                <tbody id="laporanDokterTableBody">
                    @include('dokter.partials.laporan-table', ['pemeriksaans' => $pemeriksaans])
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchLaporanDokter');
        const searchButton = document.getElementById('btnSearchLaporanDokter');
        const tableBody = document.getElementById('laporanDokterTableBody');

        let searchTimer = null;

        function searchLaporanDokter() {
            const keyword = searchInput.value;

            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="dokter-empty">
                        Memuat data riwayat pemeriksaan...
                    </td>
                </tr>
            `;

            fetch(`{{ route('dokter.laporan.ajax.search') }}?search=${encodeURIComponent(keyword)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
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
                            <td colspan="5" class="dokter-empty">
                                ${data.message ?? 'Gagal memuat data riwayat pemeriksaan'}
                            </td>
                        </tr>
                    `;
                }
            })
            .catch(function () {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="dokter-empty">
                            Terjadi kesalahan saat mencari data
                        </td>
                    </tr>
                `;
            });
        }

        if (searchButton) {
            searchButton.addEventListener('click', searchLaporanDokter);
        }

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(searchLaporanDokter, 400);
            });
        }
    });
</script>
@endsection
