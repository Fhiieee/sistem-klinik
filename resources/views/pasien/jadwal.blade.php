@extends('layouts.app')

@section('layout-type', 'pasien')
@section('active-menu', 'jadwal')

@section('page-title', 'Jadwal Dokter')
@section('page-subtitle', 'Lihat jadwal praktik dokter yang tersedia')

@section('content')
<div class="pasien-jadwal-content">

    <form action="{{ route('pasien.jadwal.index') }}" method="GET" class="pasien-jadwal-toolbar">
        <div class="pasien-jadwal-search">
            <svg viewBox="0 0 64 64">
                <circle cx="27" cy="27" r="16"></circle>
                <path d="M39 39l13 13"></path>
            </svg>

            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Cari dokter, poli, hari, atau jam..."
            >
        </div>

        <button type="submit" class="pasien-jadwal-search-btn">
            Cari
        </button>
    </form>

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
                    <circle cx="32" cy="17" r="10"></circle>
                    <path d="M16 58c3-17 11-27 16-27s13 10 16 27"></path>
                    <circle cx="45" cy="50" r="5"></circle>
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
        <div class="pasien-jadwal-panel-title">
            Daftar Jadwal Dokter
        </div>

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

                <tbody>
                    @forelse($jadwals ?? [] as $jadwal)
                        <tr>
                            <td>{{ $jadwal->dokter->user->name ?? '-' }}</td>
                            <td>{{ $jadwal->poli->nama_poli ?? '-' }}</td>
                            <td>{{ $jadwal->hari ?? '-' }}</td>
                            <td>{{ $jadwal->jam_mulai ?? '-' }}</td>
                            <td>{{ $jadwal->jam_selesai ?? '-' }}</td>
                            <td>
                                <a href="{{ route('pasien.pendaftaran.create') }}?jadwal_id={{ $jadwal->id }}" class="pasien-jadwal-action-btn">
                                    Daftar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="pasien-jadwal-empty">
                                Belum ada jadwal dokter
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
