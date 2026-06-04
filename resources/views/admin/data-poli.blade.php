@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Data Poli')
@section('page-subtitle', 'Kelola data poli klinik')
@section('active-menu', 'poli')

@section('content')
<div class="data-poli-content">

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
                id="searchPoli"
                value="{{ $search ?? '' }}"
                placeholder="Cari poli..."
            >
        </div>

        <button type="button" class="search-btn" id="btnSearchPoli">
            Cari
        </button>

        <a href="{{ route('admin.poli.create') }}" class="add-btn">
            <svg viewBox="0 0 64 64">
                <path d="M32 12v40M12 32h40"></path>
            </svg>
            Tambah Poli
        </a>
    </div>

    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg viewBox="0 0 64 64">
                    <rect x="14" y="24" width="36" height="30"></rect>
                    <path d="M25 24V12h14v12"></path>
                    <path d="M32 31v12M26 37h12"></path>
                    <path d="M20 54v-8h8v8M36 54v-8h8v8"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Total Poli</div>
                <div class="stat-number text-green">{{ $totalPoli ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>
    </div>

    <div class="poli-panel">
        <div class="panel-title">Daftar Poli</div>

        <div class="poli-table-wrap">
            <table class="poli-table">
                <thead>
                    <tr>
                        <th>Nama Poli</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="poliTableBody">
                    @include('admin.partials.poli-table', ['polis' => $polis])
                </tbody>
            </table>
        </div>
    </div>

    <div class="neo-modal-overlay" id="deletePoliModal">
        <div class="neo-modal-box">
            <div class="neo-modal-icon">
                <svg viewBox="0 0 64 64">
                    <path d="M16 18h32"></path>
                    <path d="M24 18V10h16v8"></path>
                    <path d="M22 24l2 30h16l2-30"></path>
                </svg>
            </div>

            <h2>Hapus Data Poli?</h2>
            <p>Data poli yang sudah dihapus tidak bisa dikembalikan lagi.</p>

            <div class="neo-modal-actions">
                <button type="button" class="neo-modal-btn red" id="confirmDeletePoli">
                    Ya, Hapus
                </button>

                <button type="button" class="neo-modal-btn yellow" id="cancelDeletePoli">
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
        const searchPoliInput = document.getElementById('searchPoli');
        const searchPoliButton = document.getElementById('btnSearchPoli');
        const poliTableBody = document.getElementById('poliTableBody');

        let poliSearchTimer = null;
        let selectedDeleteForm = null;

        const deletePoliModal = document.getElementById('deletePoliModal');
        const confirmDeletePoli = document.getElementById('confirmDeletePoli');
        const cancelDeletePoli = document.getElementById('cancelDeletePoli');

        function bindDeleteButtons() {
            const deletePoliButtons = document.querySelectorAll('.delete-poli-btn');

            deletePoliButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    selectedDeleteForm = this.closest('.delete-poli-form');

                    if (deletePoliModal) {
                        deletePoliModal.classList.add('show');
                    }
                });
            });
        }

        function searchPoli() {
            const keyword = searchPoliInput.value;

            poliTableBody.innerHTML = `
                <tr>
                    <td colspan="3" class="empty">Memuat data poli...</td>
                </tr>
            `;

            fetch(`{{ route('admin.poli.ajax.search') }}?search=${encodeURIComponent(keyword)}`, {
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
                    poliTableBody.innerHTML = data.html;
                    bindDeleteButtons();
                } else {
                    poliTableBody.innerHTML = `
                        <tr>
                            <td colspan="3" class="empty">Gagal memuat data poli</td>
                        </tr>
                    `;
                }
            })
            .catch(function () {
                poliTableBody.innerHTML = `
                    <tr>
                        <td colspan="3" class="empty">Terjadi kesalahan saat mencari data</td>
                    </tr>
                `;
            });
        }

        if (searchPoliButton) {
            searchPoliButton.addEventListener('click', searchPoli);
        }

        if (searchPoliInput) {
            searchPoliInput.addEventListener('keyup', function () {
                clearTimeout(poliSearchTimer);

                poliSearchTimer = setTimeout(function () {
                    searchPoli();
                }, 400);
            });
        }

        if (confirmDeletePoli) {
            confirmDeletePoli.addEventListener('click', function () {
                if (selectedDeleteForm) {
                    selectedDeleteForm.submit();
                }
            });
        }

        if (cancelDeletePoli) {
            cancelDeletePoli.addEventListener('click', function () {
                selectedDeleteForm = null;

                if (deletePoliModal) {
                    deletePoliModal.classList.remove('show');
                }
            });
        }

        if (deletePoliModal) {
            deletePoliModal.addEventListener('click', function (event) {
                if (event.target === deletePoliModal) {
                    selectedDeleteForm = null;
                    deletePoliModal.classList.remove('show');
                }
            });
        }

        bindDeleteButtons();
    });
</script>
@endsection
