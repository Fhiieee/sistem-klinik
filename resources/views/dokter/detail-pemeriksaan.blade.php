@extends('layouts.app')

@section('layout-type', 'dokter')
@section('active-menu', 'pemeriksaan')

@section('page-title', 'Detail Pemeriksaan')
@section('page-subtitle', 'Detail hasil pemeriksaan pasien')

@section('content')
<div class="dokter-detail-pemeriksaan-content">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="dokter-detail-card">

        <div class="dokter-detail-title">
            <div class="dokter-detail-title-icon">
                <svg viewBox="0 0 64 64">
                    <rect x="16" y="12" width="34" height="46" rx="3"></rect>
                    <path d="M25 12h16v-4H25z"></path>
                    <path d="M25 29h16M25 39h16M25 49h10"></path>
                </svg>
            </div>

            <div>
                <h2>Hasil Pemeriksaan Pasien</h2>
                <p>Informasi lengkap hasil pemeriksaan yang sudah disimpan.</p>
            </div>
        </div>

        <div class="dokter-detail-grid">

            <div class="dokter-detail-box green">
                <div class="dokter-detail-label">Nama Pasien</div>
                <div class="dokter-detail-value">
                    {{ $pemeriksaan->pendaftaran->pasien->user->name ?? '-' }}
                </div>
            </div>

            <div class="dokter-detail-box blue">
                <div class="dokter-detail-label">Dokter</div>
                <div class="dokter-detail-value">
                    {{ $pemeriksaan->pendaftaran->jadwal->dokter->user->name ?? '-' }}
                </div>
            </div>

            <div class="dokter-detail-box yellow">
                <div class="dokter-detail-label">Poli</div>
                <div class="dokter-detail-value">
                    {{ $pemeriksaan->pendaftaran->jadwal->poli->nama_poli ?? '-' }}
                </div>
            </div>

            <div class="dokter-detail-box red">
                <div class="dokter-detail-label">Tanggal Pemeriksaan</div>
                <div class="dokter-detail-value">
                    {{ $pemeriksaan->created_at ? $pemeriksaan->created_at->format('d-m-Y') : '-' }}
                </div>
            </div>

        </div>

        <div class="dokter-detail-section">
            <div class="dokter-detail-section-title">Keluhan</div>
            <div class="dokter-detail-section-body">
                {{ $pemeriksaan->keluhan ?? '-' }}
            </div>
        </div>

        <div class="dokter-detail-section">
            <div class="dokter-detail-section-title">Diagnosa</div>
            <div class="dokter-detail-section-body">
                {{ $pemeriksaan->diagnosa ?? '-' }}
            </div>
        </div>

        <div class="dokter-detail-section">
            <div class="dokter-detail-section-title">Resep</div>
            <div class="dokter-detail-section-body">
                {{ $pemeriksaan->resep ?? '-' }}
            </div>
        </div>

        <div class="dokter-detail-actions">
            <a href="{{ route('dokter.pemeriksaan.index') }}" class="dokter-detail-btn yellow">
                Kembali ke Pemeriksaan
            </a>

            <a href="{{ route('dokter.laporan.index') }}" class="dokter-detail-btn blue">
                Lihat Riwayat Pemeriksaan
            </a>
        </div>

    </div>

</div>
@endsection
