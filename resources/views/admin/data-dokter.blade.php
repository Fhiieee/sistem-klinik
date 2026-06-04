@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Data Dokter')
@section('page-subtitle', 'Kelola data dokter dan akun login dokter')
@section('active-menu', 'dokter')

@section('content')
<div class="data-dokter-content">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="toolbar">
        <div class="search-box">
            <svg viewBox="0 0 64 64">
                <circle cx="27" cy="27" r="16"></circle>
                <path d="M39 39l13 13"></path>
            </svg>

            <input
                type="text"
                id="searchDokter"
                value="{{ $search ?? '' }}"
                placeholder="Cari dokter..."
            >
        </div>

        <button type="button" class="search-btn" id="btnSearchDokter">
            Cari
        </button>

        <a href="{{ route('admin.dokter.create') }}" class="add-btn">
            <svg viewBox="0 0 64 64">
                <path d="M32 12v40"></path>
                <path d="M12 32h40"></path>
            </svg>
            Tambah Dokter
        </a>
    </div>

    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--green);">
                <svg viewBox="0 0 64 64">
                    <circle cx="32" cy="17" r="10"></circle>
                    <path d="M16 58c3-17 11-27 16-27s13 10 16 27"></path>
                    <path d="M24 36l8 10 8-10"></path>
                    <circle cx="45" cy="50" r="5"></circle>
                </svg>
            </div>

            <div>
                <div class="stat-label">Total Dokter</div>
                <div class="stat-number text-green">{{ $totalDokter ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--blue);">
                <svg viewBox="0 0 64 64">
                    <circle cx="22" cy="24" r="10"></circle>
                    <path d="M5 55c3-13 11-20 17-20s14 7 17 20"></path>
                    <circle cx="44" cy="26" r="8"></circle>
                    <path d="M36 55c2-9 8-15 14-15 4 0 8 2 11 7"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Dokter Aktif</div>
                <div class="stat-number text-blue">{{ $dokterAktif ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--yellow);">
                <svg viewBox="0 0 64 64">
                    <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                    <path d="M20 8v12M44 8v12M10 26h44"></path>
                    <path d="M32 34v12M26 40h12"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Jadwal Aktif</div>
                <div class="stat-number text-yellow">{{ $jadwalAktif ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-title">Daftar Dokter</div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width: 17%;">Nama Dokter</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 12%;">Spesialis</th>
                        <th style="width: 16%;">No. SIP</th>
                        <th style="width: 14%;">No. HP</th>
                        <th style="width: 8%;">Status</th>
                        <th style="width: 13%;">Aksi</th>
                    </tr>
                </thead>

                <tbody id="dokterTableBody">
                    @include('admin.partials.dokter-table', ['dokters' => $dokters])
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('extra-js')
<script>
    const searchInput = document.getElementById('searchDokter');
    const searchButton = document.getElementById('btnSearchDokter');
    const dokterTableBody = document.getElementById('dokterTableBody');

    let searchTimer = null;

    function searchDokter() {
        const keyword = searchInput.value;

        dokterTableBody.innerHTML = `
            <tr>
                <td colspan="7" class="empty">Memuat data dokter...</td>
            </tr>
        `;

        fetch(`{{ route('admin.dokter.ajax.search') }}?search=${encodeURIComponent(keyword)}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                dokterTableBody.innerHTML = data.html;
            } else {
                dokterTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="empty">Gagal memuat data dokter</td>
                    </tr>
                `;
            }
        })
        .catch(() => {
            dokterTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="empty">Terjadi kesalahan saat mencari data</td>
                </tr>
            `;
        });
    }

    searchButton.addEventListener('click', searchDokter);

    searchInput.addEventListener('keyup', function () {
        clearTimeout(searchTimer);

        searchTimer = setTimeout(function () {
            searchDokter();
        }, 400);
    });
</script>
@endsection
