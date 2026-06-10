@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Selamat datang, ' . (auth()->user()->name ?? 'Admin Klinik'))
@section('active-menu', 'dashboard')

@section('content')
<div class="dashboard-content">
    <div class="dashboard-inner">

        <div class="stat-grid">

            <div class="stat-card">
                <div class="stat-icon" style="background: var(--green);">
                    <svg viewBox="0 0 64 64">
                        <circle cx="22" cy="24" r="10"></circle>
                        <path d="M5 55c3-13 11-20 17-20s14 7 17 20"></path>
                        <circle cx="44" cy="26" r="8"></circle>
                        <path d="M36 55c2-9 8-15 14-15 4 0 8 2 11 7"></path>
                    </svg>
                </div>

                <div class="stat-info">
                    <div class="stat-label">Total Pasien</div>
                    <div class="stat-number text-green">{{ $totalPasien ?? 0 }}</div>
                </div>

                <div class="card-dots">...</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: var(--blue);">
                    <svg viewBox="0 0 64 64">
                        <circle cx="32" cy="17" r="10"></circle>
                        <path d="M16 58c3-17 11-27 16-27s13 10 16 27"></path>
                        <path d="M24 36l8 10 8-10"></path>
                        <circle cx="45" cy="50" r="5"></circle>
                    </svg>
                </div>

                <div class="stat-info">
                    <div class="stat-label">Total Dokter</div>
                    <div class="stat-number text-blue">{{ $totalDokter ?? 0 }}</div>
                </div>

                <div class="card-dots">...</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: var(--yellow);">
                    <svg viewBox="0 0 64 64">
                        <rect x="14" y="24" width="36" height="30"></rect>
                        <path d="M25 24V12h14v12"></path>
                        <path d="M32 31v12M26 37h12"></path>
                        <path d="M20 54v-8h8v8M36 54v-8h8v8"></path>
                    </svg>
                </div>

                <div class="stat-info">
                    <div class="stat-label">Data Poli</div>
                    <div class="stat-number text-yellow">{{ $totalPoli ?? 0 }}</div>
                </div>

                <div class="card-dots">...</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: var(--red);">
                    <svg viewBox="0 0 64 64">
                        <rect x="16" y="12" width="34" height="46" rx="3"></rect>
                        <path d="M25 12h16v-4H25z"></path>
                        <path d="M23 35l7 7 14-17"></path>
                    </svg>
                </div>

                <div class="stat-info">
                    <div class="stat-label">Pendaftaran<br>Hari Ini</div>
                    <div class="stat-number text-red">{{ $pendaftaranHariIni ?? 0 }}</div>
                </div>

                <div class="card-dots">...</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: var(--green);">
                    <svg viewBox="0 0 64 64">
                        <rect x="16" y="12" width="34" height="46" rx="3"></rect>
                        <path d="M25 12h16v-4H25z"></path>
                        <path d="M23 35l7 7 14-17"></path>
                        <path d="M32 22v8M28 26h8"></path>
                    </svg>
                </div>

                <div class="stat-info">
                    <div class="stat-label">Pemeriksaan<br>Selesai</div>
                    <div class="stat-number text-green">{{ $pemeriksaanSelesai ?? 0 }}</div>
                </div>

                <div class="card-dots">...</div>
            </div>

        </div>

        <div class="bottom-grid">

            <div class="panel">
                <div class="panel-title">Pendaftaran Terbaru</div>

                <div class="table-box">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 24%;">Nama Pasien</th>
                                <th style="width: 18%;">Poli</th>
                                <th style="width: 22%;">Dokter</th>
                                <th style="width: 18%;">Antrean</th>
                                <th style="width: 18%;">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse(($pendaftaranTerbaru ?? []) as $item)
                                @php
                                    $status = strtolower($item->status ?? 'menunggu');
                                @endphp

                                <tr>
                                    <td title="{{ $item->pasien?->user?->name ?? '-' }}">
                                        {{ $item->pasien?->user?->name ?? '-' }}
                                    </td>

                                    <td title="{{ $item->jadwal?->poli?->nama_poli ?? '-' }}">
                                        {{ $item->jadwal?->poli?->nama_poli ?? '-' }}
                                    </td>

                                    <td title="{{ $item->jadwal?->dokter?->user?->name ?? '-' }}">
                                        {{ $item->jadwal?->dokter?->user?->name ?? '-' }}
                                    </td>

                                    <td>
                                        A-{{ str_pad($item->nomor_antrean ?? 0, 3, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <td>
                                        <span class="badge badge-{{ $status }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty">
                                        Belum ada data pendaftaran
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('admin.pendaftaran.index') }}" class="show-all">
                    <span>Lihat Semua Data</span>

                    <svg viewBox="0 0 64 64">
                        <path d="M14 32h34"></path>
                        <path d="M36 20l12 12-12 12"></path>
                    </svg>
                </a>
            </div>

            <div class="panel quick-panel">
                <div class="panel-title">Menu Kelola</div>

                <div class="quick-list">
                    <a href="{{ route('admin.poli.create') }}" class="quick-action">
                        <div class="quick-icon">
                            <svg viewBox="0 0 64 64">
                                <rect x="14" y="24" width="36" height="30"></rect>
                                <path d="M25 24V12h14v12"></path>
                                <path d="M32 31v12M26 37h12"></path>
                                <path d="M20 54v-8h8v8M36 54v-8h8v8"></path>
                            </svg>
                        </div>

                        <div class="quick-text">Tambah Poli</div>

                        <div class="quick-arrow">
                            <svg viewBox="0 0 64 64">
                                <path d="M22 32h20"></path>
                                <path d="M34 22l10 10-10 10"></path>
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('admin.dokter.create') }}" class="quick-action blue">
                        <div class="quick-icon">
                            <svg viewBox="0 0 64 64">
                                <circle cx="32" cy="17" r="10"></circle>
                                <path d="M16 58c3-17 11-27 16-27s13 10 16 27"></path>
                                <path d="M24 36l8 10 8-10"></path>
                                <circle cx="45" cy="50" r="5"></circle>
                            </svg>
                        </div>

                        <div class="quick-text">Tambah Dokter</div>

                        <div class="quick-arrow">
                            <svg viewBox="0 0 64 64">
                                <path d="M22 32h20"></path>
                                <path d="M34 22l10 10-10 10"></path>
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('admin.jadwal.create') }}" class="quick-action red">
                        <div class="quick-icon">
                            <svg viewBox="0 0 64 64">
                                <rect x="10" y="14" width="44" height="42" rx="3"></rect>
                                <path d="M20 8v12M44 8v12M10 26h44"></path>
                                <path d="M32 34v14M25 41h14"></path>
                            </svg>
                        </div>

                        <div class="quick-text">Tambah Jadwal</div>

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
</div>
@endsection
