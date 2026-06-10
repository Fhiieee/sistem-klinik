@extends('layouts.app')

@section('layout-type', 'admin')
@section('active-menu', 'laporan')

@section('page-title', 'Detail Laporan Pemeriksaan')
@section('page-subtitle', 'Detail hasil pemeriksaan pasien')

@section('content')
<div class="admin-detail-laporan-content">

    <div class="admin-detail-laporan-card">

        <div class="admin-detail-laporan-title">
            <div class="admin-detail-laporan-title-icon">
                <svg viewBox="0 0 64 64">
                    <path d="M10 55h44"></path>
                    <rect x="14" y="38" width="7" height="17"></rect>
                    <rect x="28" y="28" width="7" height="27"></rect>
                    <rect x="42" y="17" width="7" height="38"></rect>
                </svg>
            </div>

            <div>
                <h2>Detail Laporan Pemeriksaan</h2>
                <p>Informasi lengkap hasil pemeriksaan pasien.</p>
            </div>
        </div>

        <div class="admin-detail-laporan-grid">

            <div class="admin-detail-laporan-box green">
                <div class="admin-detail-laporan-label">Nama Pasien</div>
                <div class="admin-detail-laporan-value">
                    {{ $pemeriksaan->pendaftaran->pasien->user->name ?? '-' }}
                </div>
            </div>

            <div class="admin-detail-laporan-box blue">
                <div class="admin-detail-laporan-label">Dokter</div>
                <div class="admin-detail-laporan-value">
                    {{ $pemeriksaan->pendaftaran->jadwal->dokter->user->name ?? '-' }}
                </div>
            </div>

            <div class="admin-detail-laporan-box yellow">
                <div class="admin-detail-laporan-label">Poli</div>
                <div class="admin-detail-laporan-value">
                    {{ $pemeriksaan->pendaftaran->jadwal->poli->nama_poli ?? '-' }}
                </div>
            </div>

            <div class="admin-detail-laporan-box red">
                <div class="admin-detail-laporan-label">Tanggal Pemeriksaan</div>
                <div class="admin-detail-laporan-value">
                    {{ $pemeriksaan->created_at ? $pemeriksaan->created_at->format('d-m-Y') : '-' }}
                </div>
            </div>

        </div>

        <div class="admin-detail-laporan-section">
            <div class="admin-detail-laporan-section-title">Keluhan</div>
            <div class="admin-detail-laporan-section-body">
                {{ $pemeriksaan->keluhan ?? '-' }}
            </div>
        </div>

        <div class="admin-detail-laporan-section">
            <div class="admin-detail-laporan-section-title">Diagnosa</div>
            <div class="admin-detail-laporan-section-body">
                {{ $pemeriksaan->diagnosa ?? '-' }}
            </div>
        </div>

        <div class="admin-detail-laporan-section">
            <div class="admin-detail-laporan-section-title">Resep</div>
            <div class="admin-detail-laporan-section-body">
                {{ $pemeriksaan->resep ?? '-' }}
            </div>
        </div>

        <div class="admin-detail-laporan-actions">
            <a href="{{ route('admin.laporan.index') }}" class="admin-detail-laporan-btn yellow">
                Kembali ke Laporan
            </a>
        </div>

    </div>

</div>
@endsection
