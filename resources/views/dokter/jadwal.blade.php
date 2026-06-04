@extends('layouts.app')
@section('layout-type', 'dokter')

@section('page-title', 'Jadwal Saya')
@section('page-subtitle', 'Lihat jadwal praktik dokter')
@section('active-menu', 'jadwal')

@section('content')
<div class="dokter-jadwal-content">

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

    <form action="{{ route('dokter.jadwal.index') }}" method="GET" class="dokter-toolbar">
        <div class="dokter-search-box">
            <svg viewBox="0 0 64 64">
                <circle cx="27" cy="27" r="16"></circle>
                <path d="M39 39l14 14"></path>
            </svg>

            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Cari hari, poli, atau jam..."
            >
        </div>

        <button type="submit" class="dokter-search-btn">
            Cari
        </button>
    </form>

    <div class="dokter-panel">
        <div class="dokter-panel-title">Daftar Jadwal Saya</div>

        <div class="dokter-table-wrap">
            <table class="dokter-table">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($jadwals ?? [] as $jadwal)
                        <tr>
                            <td>{{ $jadwal->hari ?? '-' }}</td>
                            <td>{{ $jadwal->jam_mulai ?? '-' }}</td>
                            <td>{{ $jadwal->jam_selesai ?? '-' }}</td>
                            <td>{{ $jadwal->poli->nama_poli ?? '-' }}</td>
                            <td>{{ $jadwal->dokter->user->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="dokter-empty">
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
