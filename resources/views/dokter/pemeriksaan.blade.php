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

    <form action="{{ route('dokter.pemeriksaan.index') }}" method="GET" class="dokter-toolbar">
        <div class="dokter-search-box">
            <svg viewBox="0 0 64 64">
                <circle cx="27" cy="27" r="16"></circle>
                <path d="M39 39l14 14"></path>
            </svg>

            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Cari pasien, poli, status..."
            >
        </div>

        <button type="submit" class="dokter-search-btn">
            Cari
        </button>
    </form>

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

                <tbody>
                    @forelse($pendaftarans ?? [] as $pendaftaran)
                        <tr>
                            <td>{{ $pendaftaran->pasien->user->name ?? '-' }}</td>
                            <td>{{ $pendaftaran->jadwal->poli->nama_poli ?? '-' }}</td>
                            <td>{{ $pendaftaran->tanggal_daftar ?? '-' }}</td>
                            <td>{{ $pendaftaran->nomor_antrean ?? $pendaftaran->nomor_antrian ?? '-' }}</td>
                            <td>
                                <span class="dokter-status {{ $pendaftaran->status ?? 'menunggu' }}">
                                    {{ ucfirst($pendaftaran->status ?? '-') }}
                                </span>
                            </td>
                            <td>
                                <div class="dokter-action-cell">
                                    @if($pendaftaran->pemeriksaan)
                                        <a href="{{ route('dokter.pemeriksaan.edit', $pendaftaran->pemeriksaan->id) }}" class="dokter-action-btn yellow">
                                            Edit
                                        </a>
                                    @else
                                        <a href="{{ route('dokter.pemeriksaan.create', $pendaftaran->id) }}" class="dokter-action-btn green">
                                            Periksa
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="dokter-empty">
                                Belum ada pasien untuk diperiksa
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
