@extends('layouts.app')

@section('layout-type', 'dokter')
@section('active-menu', 'jadwal')

@section('page-title', 'Jadwal Saya')
@section('page-subtitle', 'Lihat jadwal praktik dokter')

@section('content')
<div class="data-jadwal-content dokter-jadwal-page">

    <div class="toolbar dokter-toolbar">
        <div class="search-box">
            <svg viewBox="0 0 64 64">
                <circle cx="27" cy="27" r="16"></circle>
                <path d="M39 39l13 13"></path>
            </svg>

            <input
                type="text"
                id="searchJadwalDokter"
                value="{{ $search ?? '' }}"
                placeholder="Cari hari, poli, atau jam..."
            >
        </div>

        <button type="button" class="search-btn" id="btnSearchJadwalDokter">
            Cari
        </button>
    </div>

    <div class="jadwal-panel">
        <div class="panel-title">
            Daftar Jadwal Saya
        </div>

        <div class="jadwal-table-wrap">
            <table class="jadwal-table">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                    </tr>
                </thead>

                <tbody id="jadwalDokterTableBody">
                    @include('dokter.partials.jadwal-table', ['jadwals' => $jadwals])
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchJadwalDokter');
        const searchButton = document.getElementById('btnSearchJadwalDokter');
        const tableBody = document.getElementById('jadwalDokterTableBody');

        let searchTimer = null;

        function searchJadwalDokter() {
            const keyword = searchInput.value;

            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="empty">
                        Memuat data jadwal...
                    </td>
                </tr>
            `;

            fetch(`{{ route('dokter.jadwal.ajax.search') }}?search=${encodeURIComponent(keyword)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(async function (response) {
                const text = await response.text();

                if (!response.ok) {
                    throw new Error(text);
                }

                return JSON.parse(text);
            })
            .then(function (data) {
                if (data.status === 'success') {
                    tableBody.innerHTML = data.html;
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="5" class="empty">
                                Gagal memuat data jadwal
                            </td>
                        </tr>
                    `;
                }
            })
            .catch(function (error) {
                console.error('AJAX Error:', error);

                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="empty">
                            Terjadi kesalahan saat mencari data
                        </td>
                    </tr>
                `;
            });
        }

        if (searchButton) {
            searchButton.addEventListener('click', searchJadwalDokter);
        }

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(searchJadwalDokter, 400);
            });
        }
    });
</script>
@endsection
