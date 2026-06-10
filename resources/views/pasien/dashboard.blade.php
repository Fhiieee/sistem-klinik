@extends('layouts.app')
@section('layout-type', 'pasien')

@section('page-title', 'Dashboard Pasien')
@section('page-subtitle', 'Selamat datang, Pasien Klinik Sehati')
@section('active-menu', 'dashboard')

@section('content')
<div class="pasien-dashboard-content">

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
            <div class="stat-icon yellow">
                <svg viewBox="0 0 64 64">
                    <circle cx="32" cy="32" r="22"></circle>
                    <path d="M32 18v16l10 7"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Pendaftaran Menunggu</div>
                <div class="stat-number text-yellow">{{ $pendaftaranMenunggu ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <svg viewBox="0 0 64 64">
                    <rect x="14" y="14" width="36" height="40" rx="3"></rect>
                    <path d="M24 29l6 6 12-13"></path>
                    <path d="M22 44h20"></path>
                </svg>
            </div>

            <div>
                <div class="stat-label">Pemeriksaan Selesai</div>
                <div class="stat-number text-blue">{{ $pemeriksaanSelesai ?? 0 }}</div>
            </div>

            <div class="card-dots">...</div>
        </div>
    </div>

    <div class="dashboard-grid">

        <div class="panel">
            <div class="panel-title">Pendaftaran Terbaru</div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Dokter</th>
                            <th>Poli</th>
                            <th>Hari</th>
                            <th>Tanggal Daftar</th>
                            <th>No. Antrean</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pendaftaranTerbaru ?? [] as $pendaftaran)
                            <tr>
                                <td>{{ $pendaftaran->jadwal->dokter->user->name ?? '-' }}</td>
                                <td>{{ $pendaftaran->jadwal->poli->nama_poli ?? '-' }}</td>
                                <td>{{ $pendaftaran->jadwal->hari ?? '-' }}</td>
                                <td>{{ $pendaftaran->tanggal_daftar ?? '-' }}</td>
                                <td>{{ $pendaftaran->nomor_antrian ?? $pendaftaran->nomor_antrean ?? '-' }}</td>
                                <td>
                                    <span class="status {{ $pendaftaran->status ?? 'menunggu' }}">
                                        {{ ucfirst($pendaftaran->status ?? 'menunggu') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty">
                                    Belum ada pendaftaran pemeriksaan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel quick-panel">
            <div class="panel-title">Menu Cepat</div>

            <div class="quick-list">
                <a href="{{ route('pasien.jadwal.index') }}" class="quick-action">
                    <div class="quick-icon">
                        <svg viewBox="0 0 64 64">
                            <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                            <path d="M20 8v12M44 8v12M10 26h44"></path>
                        </svg>
                    </div>

                    <div class="quick-text">Lihat Jadwal Dokter</div>

                    <div class="quick-arrow">
                        <svg viewBox="0 0 64 64">
                            <path d="M22 32h20"></path>
                            <path d="M34 22l10 10-10 10"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('pasien.pendaftaran.create') }}" class="quick-action blue">
                    <div class="quick-icon">
                        <svg viewBox="0 0 64 64">
                            <path d="M32 12v40"></path>
                            <path d="M12 32h40"></path>
                        </svg>
                    </div>

                    <div class="quick-text">Daftar Pemeriksaan</div>

                    <div class="quick-arrow">
                        <svg viewBox="0 0 64 64">
                            <path d="M22 32h20"></path>
                            <path d="M34 22l10 10-10 10"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('pasien.pendaftaran.index') }}" class="quick-action yellow">
                    <div class="quick-icon">
                        <svg viewBox="0 0 64 64">
                            <rect x="16" y="12" width="34" height="46" rx="3"></rect>
                            <path d="M25 12h16v-4H25z"></path>
                            <path d="M25 29h16M25 39h16M25 49h10"></path>
                        </svg>
                    </div>

                    <div class="quick-text">Riwayat Pendaftaran</div>

                    <div class="quick-arrow">
                        <svg viewBox="0 0 64 64">
                            <path d="M22 32h20"></path>
                            <path d="M34 22l10 10-10 10"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('pasien.riwayat.index') }}" class="quick-action red">
                    <div class="quick-icon">
                        <svg viewBox="0 0 64 64">
                            <path d="M10 55h44"></path>
                            <rect x="14" y="38" width="7" height="17"></rect>
                            <rect x="28" y="28" width="7" height="27"></rect>
                            <rect x="42" y="17" width="7" height="38"></rect>
                        </svg>
                    </div>

                    <div class="quick-text">Riwayat Pemeriksaan</div>

                    <div class="quick-arrow">
                        <svg viewBox="0 0 64 64">
                            <path d="M22 32h20"></path>
                            <path d="M34 22l10 10-10 10"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
