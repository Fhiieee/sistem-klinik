@extends('layouts.app')
@section('layout-type', 'pasien')

@section('page-title', 'Jadwal Dokter')
@section('page-subtitle', 'Lihat jadwal praktik dokter yang tersedia')
@section('active-menu', 'jadwal')

@section('content')
<div class="pasien-jadwal-content">

    <div class="pasien-jadwal-toolbar">
        <div class="pasien-jadwal-search">
            <svg viewBox="0 0 64 64">
                <circle cx="27" cy="27" r="16"></circle>
                <path d="M39 39l14 14"></path>
            </svg>

            <input
                type="text"
                id="searchJadwalPasien"
                value="{{ $search ?? '' }}"
                placeholder="Cari dokter, poli, hari, atau jam..."
            >
        </div>

        <button type="button" class="pasien-jadwal-search-btn" id="btnSearchJadwalPasien">
            Cari
        </button>
    </div>

    <div class="pasien-jadwal-stat-row">
        <div class="pasien-jadwal-stat-card">
            <div class="pasien-jadwal-stat-icon green">
                <svg viewBox="0 0 64 64">
                    <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                    <path d="M20 8v12M44 8v12M10 26h44"></path>
                </svg>
            </div>

            <div>
                <div class="pasien-jadwal-stat-label">Total Jadwal</div>
                <div class="pasien-jadwal-stat-number text-green">{{ $totalJadwal ?? 0 }}</div>
            </div>

            <div class="pasien-jadwal-card-dots">...</div>
        </div>

        <div class="pasien-jadwal-stat-card">
            <div class="pasien-jadwal-stat-icon blue">
                <svg viewBox="0 0 64 64">
                    <circle cx="32" cy="22" r="12"></circle>
                    <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                </svg>
            </div>

            <div>
                <div class="pasien-jadwal-stat-label">Total Dokter</div>
                <div class="pasien-jadwal-stat-number text-blue">{{ $totalDokter ?? 0 }}</div>
            </div>

            <div class="pasien-jadwal-card-dots">...</div>
        </div>

        <div class="pasien-jadwal-stat-card">
            <div class="pasien-jadwal-stat-icon yellow">
                <svg viewBox="0 0 64 64">
                    <rect x="14" y="24" width="36" height="30"></rect>
                    <path d="M25 24V12h14v12"></path>
                    <path d="M32 31v12M26 37h12"></path>
                    <path d="M20 54v-8h8v8M36 54v-8h8v8"></path>
                </svg>
            </div>

            <div>
                <div class="pasien-jadwal-stat-label">Total Poli</div>
                <div class="pasien-jadwal-stat-number text-yellow">{{ $totalPoli ?? 0 }}</div>
            </div>

            <div class="pasien-jadwal-card-dots">...</div>
        </div>
    </div>

    <div class="pasien-jadwal-panel">
        <div class="pasien-jadwal-panel-title">Daftar Jadwal Dokter</div>

        <div class="pasien-jadwal-table-wrap">
            <table class="pasien-jadwal-table">
                <thead>
                    <tr>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="jadwalPasienTableBody">
                    @include('pasien.partials.jadwal-table', ['jadwals' => $jadwals])
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchJadwalPasien');
        const searchButton = document.getElementById('btnSearchJadwalPasien');
        const tableBody = document.getElementById('jadwalPasienTableBody');

        let searchTimer = null;

        function searchJadwalPasien() {
            const keyword = searchInput.value;

            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="pasien-jadwal-empty">Memuat data jadwal dokter...</td>
                </tr>
            `;

            fetch(`{{ route('pasien.jadwal.ajax.search') }}?search=${encodeURIComponent(keyword)}`, {
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
                            <td colspan="6" class="pasien-jadwal-empty">Gagal memuat data jadwal dokter</td>
                        </tr>
                    `;
                }
            })
            .catch(function () {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="pasien-jadwal-empty">Terjadi kesalahan saat mencari data</td>
                    </tr>
                `;
            });
        }

        searchButton.addEventListener('click', searchJadwalPasien);

        searchInput.addEventListener('keyup', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(searchJadwalPasien, 400);
        });
    });
</script>
@endsection
