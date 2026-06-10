@extends('layouts.app')
@section('layout-type', 'dokter')

@section('page-title', 'Pemeriksaan Pasien')
@section('page-subtitle', 'Kelola data pemeriksaan pasien')
@section('active-menu', 'pemeriksaan')

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
                id="searchPemeriksaanDokter"
                value="{{ $search ?? '' }}"
                placeholder="Cari pasien, poli, status..."
            >
        </div>

        <button type="button" class="dokter-search-btn" id="btnSearchPemeriksaanDokter">
            Cari
        </button>
    </div>

    <div class="dokter-panel">
        <div class="dokter-panel-title">Daftar Pasien Pemeriksaan</div>

        <div class="dokter-table-wrap">
            <table class="dokter-table">
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>Poli</th>
                        <th>Tanggal Daftar</th>
                        <th>No. Antrean</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="pemeriksaanDokterTableBody">
                    @include('dokter.partials.pemeriksaan-table', ['pendaftarans' => $pendaftarans])
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchPemeriksaanDokter');
        const searchButton = document.getElementById('btnSearchPemeriksaanDokter');
        const tableBody = document.getElementById('pemeriksaanDokterTableBody');

        let searchTimer = null;

        function searchPemeriksaanDokter() {
            const keyword = searchInput.value;

            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="dokter-empty">
                        Memuat data pemeriksaan...
                    </td>
                </tr>
            `;

            fetch(`{{ route('dokter.pemeriksaan.ajax.search') }}?search=${encodeURIComponent(keyword)}`, {
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
                            <td colspan="6" class="dokter-empty">
                                ${data.message ?? 'Gagal memuat data pemeriksaan'}
                            </td>
                        </tr>
                    `;
                }
            })
            .catch(function () {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="dokter-empty">
                            Terjadi kesalahan saat mencari data
                        </td>
                    </tr>
                `;
            });
        }

        if (searchButton) {
            searchButton.addEventListener('click', searchPemeriksaanDokter);
        }

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(searchPemeriksaanDokter, 400);
            });
        }
    });
</script>
@endsection
