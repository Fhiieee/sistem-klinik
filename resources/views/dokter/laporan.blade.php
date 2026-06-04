@extends('layouts.app')
@section('layout-type', 'dokter')

@section('page-title', 'Riwayat Pemeriksaan')
@section('page-subtitle', 'Lihat riwayat pemeriksaan yang sudah dilakukan')
@section('active-menu', 'laporan')

@section('content')
<div class="dokter-laporan-content">

    <form action="{{ route('dokter.laporan.index') }}" method="GET" class="dokter-toolbar">
        <div class="dokter-search-box">
            <svg viewBox="0 0 64 64">
                <circle cx="27" cy="27" r="16"></circle>
                <path d="M39 39l14 14"></path>
            </svg>

            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Cari pasien, diagnosa, resep..."
            >
        </div>

        <button type="submit" class="dokter-search-btn">
            Cari
        </button>
    </form>

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

                <tbody>
                    @forelse($pemeriksaans ?? [] as $pemeriksaan)
                        <tr>
                            <td>{{ $pemeriksaan->pendaftaran->pasien->user->name ?? '-' }}</td>
                            <td>{{ $pemeriksaan->pendaftaran->jadwal->poli->nama_poli ?? '-' }}</td>
                            <td class="text-left">{{ $pemeriksaan->keluhan ?? '-' }}</td>
                            <td class="text-left">{{ $pemeriksaan->diagnosa ?? '-' }}</td>
                            <td class="text-left">{{ $pemeriksaan->resep ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="dokter-empty">
                                Belum ada riwayat pemeriksaan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
