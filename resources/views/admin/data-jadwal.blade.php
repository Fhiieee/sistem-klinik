@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Jadwal Dokter')
@section('page-subtitle', 'Kelola jadwal praktik dokter')
@section('active-menu', 'jadwal')

@section('content')
<div class="data-jadwal-content">

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
                id="searchJadwal"
                value="{{ $search ?? '' }}"
                placeholder="Cari jadwal..."
            >
        </div>

        <button type="button" class="search-btn" id="btnSearchJadwal">
            Cari
        </button>

        <a href="{{ route('admin.jadwal.create') }}" class="add-btn">
            <svg viewBox="0 0 64 64">
                <path d="M32 12v40M12 32h40"></path>
            </svg>
            Tambah Jadwal
        </a>
    </div>

    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg viewBox="0 0 64 64">
                    <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                    <path d="M20 8v12M44 8v12M10 26h44"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Total Jadwal</div>
                <div class="stat-number text-green">{{ $totalJadwal ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <svg viewBox="0 0 64 64">
                    <circle cx="32" cy="22" r="12"></circle>
                    <path d="M12 56c3-14 13-22 20-22s17 8 20 22"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Total Dokter</div>
                <div class="stat-number text-blue">{{ $totalDokter ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg viewBox="0 0 64 64">
                    <rect x="14" y="24" width="36" height="30"></rect>
                    <path d="M25 24V12h14v12"></path>
                    <path d="M32 31v12M26 37h12"></path>
                    <path d="M20 54v-8h8v8M36 54v-8h8v8"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Total Poli</div>
                <div class="stat-number text-yellow">{{ $totalPoli ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>
    </div>

    <div class="jadwal-panel">
        <div class="panel-title">Daftar Jadwal Dokter</div>

        <div class="jadwal-table-wrap">
            <table class="jadwal-table">
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

                <tbody id="jadwalTableBody">
                    @include('admin.partials.jadwal-table', ['jadwals' => $jadwals])
                </tbody>
            </table>
        </div>
    </div>

    <div class="neo-modal-overlay" id="deleteJadwalModal">
        <div class="neo-modal-box">
            <div class="neo-modal-icon">
                <svg viewBox="0 0 64 64">
                    <path d="M16 18h32"></path>
                    <path d="M24 18V10h16v8"></path>
                    <path d="M22 24l2 30h16l2-30"></path>
                </svg>
            </div>

            <h2>Hapus Data Jadwal?</h2>
            <p>Data jadwal dokter yang sudah dihapus tidak bisa dikembalikan lagi.</p>

            <div class="neo-modal-actions">
                <button type="button" class="neo-modal-btn red" id="confirmDeleteJadwal">
                    Ya, Hapus
                </button>

                <button type="button" class="neo-modal-btn yellow" id="cancelDeleteJadwal">
                    Batal
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchJadwalInput = document.getElementById('searchJadwal');
        const searchJadwalButton = document.getElementById('btnSearchJadwal');
        const jadwalTableBody = document.getElementById('jadwalTableBody');

        let jadwalSearchTimer = null;
        let selectedDeleteForm = null;

        const deleteJadwalModal = document.getElementById('deleteJadwalModal');
        const confirmDeleteJadwal = document.getElementById('confirmDeleteJadwal');
        const cancelDeleteJadwal = document.getElementById('cancelDeleteJadwal');

        function bindDeleteButtons() {
            const deleteJadwalButtons = document.querySelectorAll('.delete-jadwal-btn');

            deleteJadwalButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    selectedDeleteForm = this.closest('.delete-jadwal-form');

                    if (deleteJadwalModal) {
                        deleteJadwalModal.classList.add('show');
                    }
                });
            });
        }

        function searchJadwal() {
            const keyword = searchJadwalInput.value;

            jadwalTableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="empty">Memuat data jadwal dokter...</td>
                </tr>
            `;

            fetch(`{{ route('admin.jadwal.ajax.search') }}?search=${encodeURIComponent(keyword)}`, {
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
                    jadwalTableBody.innerHTML = data.html;
                    bindDeleteButtons();
                } else {
                    jadwalTableBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="empty">Gagal memuat data jadwal dokter</td>
                        </tr>
                    `;
                }
            })
            .catch(function () {
                jadwalTableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="empty">Terjadi kesalahan saat mencari data</td>
                    </tr>
                `;
            });
        }

        if (searchJadwalButton) {
            searchJadwalButton.addEventListener('click', searchJadwal);
        }

        if (searchJadwalInput) {
            searchJadwalInput.addEventListener('keyup', function () {
                clearTimeout(jadwalSearchTimer);

                jadwalSearchTimer = setTimeout(function () {
                    searchJadwal();
                }, 400);
            });
        }

        if (confirmDeleteJadwal) {
            confirmDeleteJadwal.addEventListener('click', function () {
                if (selectedDeleteForm) {
                    selectedDeleteForm.submit();
                }
            });
        }

        if (cancelDeleteJadwal) {
            cancelDeleteJadwal.addEventListener('click', function () {
                selectedDeleteForm = null;

                if (deleteJadwalModal) {
                    deleteJadwalModal.classList.remove('show');
                }
            });
        }

        if (deleteJadwalModal) {
            deleteJadwalModal.addEventListener('click', function (event) {
                if (event.target === deleteJadwalModal) {
                    selectedDeleteForm = null;
                    deleteJadwalModal.classList.remove('show');
                }
            });
        }

        bindDeleteButtons();
    });
</script>
@endsection
