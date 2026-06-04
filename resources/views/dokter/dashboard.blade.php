@extends('layouts.app')
@section('layout-type', 'dokter')

@section('page-title', 'Dashboard Dokter')
@section('page-subtitle', 'Ringkasan jadwal dan pemeriksaan dokter')
@section('active-menu', 'dashboard')

@section('content')
<div class="dokter-dashboard-content">

    <div class="dokter-stat-row">
        <div class="dokter-stat-card">
            <div class="dokter-stat-icon blue">
                <svg viewBox="0 0 64 64">
                    <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                    <path d="M20 8v12M44 8v12M10 26h44"></path>
                </svg>
            </div>

            <div>
                <div class="dokter-stat-label">Total Jadwal Saya</div>
                <div class="dokter-stat-number dokter-text-blue">{{ $totalJadwal ?? 0 }}</div>
            </div>

            <div class="dokter-card-dots">...</div>
        </div>

        <div class="dokter-stat-card">
            <div class="dokter-stat-icon yellow">
                <svg viewBox="0 0 64 64">
                    <rect x="16" y="12" width="34" height="46" rx="3"></rect>
                    <path d="M25 12h16v-4H25z"></path>
                    <path d="M25 29h16M25 39h16M25 49h10"></path>
                </svg>
            </div>

            <div>
                <div class="dokter-stat-label">Pasien Menunggu</div>
                <div class="dokter-stat-number dokter-text-yellow">{{ $pasienMenunggu ?? 0 }}</div>
            </div>

            <div class="dokter-card-dots">...</div>
        </div>

        <div class="dokter-stat-card">
            <div class="dokter-stat-icon green">
                <svg viewBox="0 0 64 64">
                    <path d="M14 34l12 12 24-28"></path>
                    <circle cx="32" cy="32" r="25"></circle>
                </svg>
            </div>

            <div>
                <div class="dokter-stat-label">Pemeriksaan Selesai</div>
                <div class="dokter-stat-number dokter-text-green">{{ $pemeriksaanSelesai ?? 0 }}</div>
            </div>

            <div class="dokter-card-dots">...</div>
        </div>
    </div>

    <div class="dokter-panel">
        <div class="dokter-panel-title">Pendaftaran Terbaru</div>

        <div class="dokter-table-wrap">
            <table class="dokter-table">
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>Poli</th>
                        <th>Tanggal</th>
                        <th>No. Antrean</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pendaftaranTerbaru ?? [] as $pendaftaran)
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="dokter-empty">
                                Belum ada data pendaftaran
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
