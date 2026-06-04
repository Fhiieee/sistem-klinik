@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Data Pendaftaran')
@section('page-subtitle', 'Kelola data pendaftaran pasien')
@section('active-menu', 'pendaftaran')

@section('content')
<div class="data-pendaftaran-content">

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
                id="searchPendaftaran"
                value="{{ $search ?? '' }}"
                placeholder="Cari pendaftaran..."
            >
        </div>

        <button type="button" class="search-btn" id="btnSearchPendaftaran">
            Cari
        </button>
    </div>

    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg viewBox="0 0 64 64">
                    <rect x="16" y="12" width="34" height="46" rx="3"></rect>
                    <path d="M25 12h16v-4H25z"></path>
                    <path d="M25 29h16M25 39h16M25 49h10"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Total Pendaftaran</div>
                <div class="stat-number text-green">{{ $totalPendaftaran ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <svg viewBox="0 0 64 64">
                    <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                    <path d="M20 8v12M44 8v12M10 26h44"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Pendaftaran Hari Ini</div>
                <div class="stat-number text-blue">{{ $pendaftaranHariIni ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg viewBox="0 0 64 64">
                    <rect x="16" y="10" width="32" height="44" rx="3"></rect>
                    <path d="M25 32l5 5 10-13"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Pendaftaran Selesai</div>
                <div class="stat-number text-yellow">{{ $pendaftaranSelesai ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>
    </div>

    <div class="pendaftaran-panel">
        <div class="panel-title">Daftar Pendaftaran</div>

        <div class="pendaftaran-table-wrap">
            <table class="pendaftaran-table">
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                        <th>Tanggal</th>
                        <th>Antrean</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="pendaftaranTableBody">
                    @include('admin.partials.pendaftaran-table', ['pendaftarans' => $pendaftarans])
                </tbody>
            </table>
        </div>
    </div>

    <div class="neo-modal-overlay" id="deletePendaftaranModal">
        <div class="neo-modal-box">
            <div class="neo-modal-icon">
                <svg viewBox="0 0 64 64">
                    <path d="M16 18h32"></path>
                    <path d="M24 18V10h16v8"></path>
                    <path d="M22 24l2 30h16l2-30"></path>
                </svg>
            </div>

            <h2>Hapus Data Pendaftaran?</h2>
            <p>Data pendaftaran yang sudah dihapus tidak bisa dikembalikan lagi.</p>

            <div class="neo-modal-actions">
                <button type="button" class="neo-modal-btn red" id="confirmDeletePendaftaran">
                    Ya, Hapus
                </button>

                <button type="button" class="neo-modal-btn yellow" id="cancelDeletePendaftaran">
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
        const searchPendaftaranInput = document.getElementById('searchPendaftaran');
        const searchPendaftaranButton = document.getElementById('btnSearchPendaftaran');
        const pendaftaranTableBody = document.getElementById('pendaftaranTableBody');

        let pendaftaranSearchTimer = null;
        let selectedDeleteForm = null;

        const deletePendaftaranModal = document.getElementById('deletePendaftaranModal');
        const confirmDeletePendaftaran = document.getElementById('confirmDeletePendaftaran');
        const cancelDeletePendaftaran = document.getElementById('cancelDeletePendaftaran');

        function bindDeleteButtons() {
            const deletePendaftaranButtons = document.querySelectorAll('.delete-pendaftaran-btn');

            deletePendaftaranButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    selectedDeleteForm = this.closest('.delete-pendaftaran-form');

                    if (deletePendaftaranModal) {
                        deletePendaftaranModal.classList.add('show');
                    }
                });
            });
        }

        function searchPendaftaran() {
            const keyword = searchPendaftaranInput.value;

            pendaftaranTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="empty">Memuat data pendaftaran...</td>
                </tr>
            `;

            fetch(`{{ route('admin.pendaftaran.ajax.search') }}?search=${encodeURIComponent(keyword)}`, {
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
                    pendaftaranTableBody.innerHTML = data.html;
                    bindDeleteButtons();
                } else {
                    pendaftaranTableBody.innerHTML = `
                        <tr>
                            <td colspan="7" class="empty">Gagal memuat data pendaftaran</td>
                        </tr>
                    `;
                }
            })
            .catch(function () {
                pendaftaranTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="empty">Terjadi kesalahan saat mencari data</td>
                    </tr>
                `;
            });
        }

        if (searchPendaftaranButton) {
            searchPendaftaranButton.addEventListener('click', searchPendaftaran);
        }

        if (searchPendaftaranInput) {
            searchPendaftaranInput.addEventListener('keyup', function () {
                clearTimeout(pendaftaranSearchTimer);

                pendaftaranSearchTimer = setTimeout(function () {
                    searchPendaftaran();
                }, 400);
            });
        }

        if (confirmDeletePendaftaran) {
            confirmDeletePendaftaran.addEventListener('click', function () {
                if (selectedDeleteForm) {
                    selectedDeleteForm.submit();
                }
            });
        }

        if (cancelDeletePendaftaran) {
            cancelDeletePendaftaran.addEventListener('click', function () {
                selectedDeleteForm = null;

                if (deletePendaftaranModal) {
                    deletePendaftaranModal.classList.remove('show');
                }
            });
        }

        if (deletePendaftaranModal) {
            deletePendaftaranModal.addEventListener('click', function (event) {
                if (event.target === deletePendaftaranModal) {
                    selectedDeleteForm = null;
                    deletePendaftaranModal.classList.remove('show');
                }
            });
        }

        bindDeleteButtons();
    });
</script>
@endsection
