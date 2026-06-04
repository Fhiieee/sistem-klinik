@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Data Pasien')
@section('page-subtitle', 'Kelola data pasien klinik')
@section('active-menu', 'pasien')

@section('content')
<div class="data-pasien-content">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--green);">
                <svg viewBox="0 0 64 64">
                    <circle cx="24" cy="24" r="9"></circle>
                    <path d="M8 55c3-13 10-20 16-20s13 7 16 20"></path>
                    <circle cx="43" cy="26" r="8"></circle>
                    <path d="M35 55c2-9 8-15 14-15 4 0 8 2 11 7"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Total Pasien</div>
                <div class="stat-number text-green">{{ $totalPasien ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--yellow);">
                <svg viewBox="0 0 64 64">
                    <circle cx="28" cy="24" r="10"></circle>
                    <path d="M10 56c3-14 11-22 18-22s15 8 18 22"></path>
                    <path d="M48 18v18"></path>
                    <path d="M39 27h18"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Pasien Baru Hari Ini</div>
                <div class="stat-number text-yellow">{{ $pasienBaruHariIni ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>
    </div>

    <div class="toolbar">
        <div class="search-box">
            <svg viewBox="0 0 64 64">
                <circle cx="27" cy="27" r="16"></circle>
                <path d="M39 39l13 13"></path>
            </svg>

            <input
                type="text"
                id="searchPasien"
                value="{{ $search ?? '' }}"
                placeholder="Cari pasien..."
            >
        </div>

        <button type="button" class="search-btn" id="btnSearchPasien">
            Cari
        </button>

        <a href="{{ route('admin.pasien.create') }}" class="add-btn">
            <svg viewBox="0 0 64 64">
                <path d="M32 12v40"></path>
                <path d="M12 32h40"></path>
            </svg>
            Tambah Pasien
        </a>
    </div>

    <div class="panel">
        <div class="panel-title">Daftar Pasien</div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width: 18%;">Nama Pasien</th>
                        <th style="width: 17%;">NIK</th>
                        <th style="width: 12%;">Jenis Kelamin</th>
                        <th style="width: 13%;">No. HP</th>
                        <th style="width: 18%;">Alamat</th>
                        <th style="width: 8%;">Status</th>
                        <th style="width: 14%;">Aksi</th>
                    </tr>
                </thead>

                <tbody id="pasienTableBody">
                    @include('admin.partials.pasien-table', ['pasiens' => $pasiens])
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('extra-js')
<script>
    const searchPasienInput = document.getElementById('searchPasien');
    const searchPasienButton = document.getElementById('btnSearchPasien');
    const pasienTableBody = document.getElementById('pasienTableBody');

    let pasienSearchTimer = null;

    function searchPasien() {
        const keyword = searchPasienInput.value;

        pasienTableBody.innerHTML = `
            <tr>
                <td colspan="7" class="empty">Memuat data pasien...</td>
            </tr>
        `;

        fetch(`{{ route('admin.pasien.ajax.search') }}?search=${encodeURIComponent(keyword)}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                pasienTableBody.innerHTML = data.html;
            } else {
                pasienTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="empty">Gagal memuat data pasien</td>
                    </tr>
                `;
            }
        })
        .catch(() => {
            pasienTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="empty">Terjadi kesalahan saat mencari data</td>
                </tr>
            `;
        });
    }

    searchPasienButton.addEventListener('click', searchPasien);

    searchPasienInput.addEventListener('keyup', function () {
        clearTimeout(pasienSearchTimer);

        pasienSearchTimer = setTimeout(function () {
            searchPasien();
        }, 400);
    });
</script>
@endsection
