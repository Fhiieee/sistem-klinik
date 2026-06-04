@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Detail Laporan')
@section('page-subtitle', 'Detail hasil pemeriksaan pasien')
@section('active-menu', 'laporan')

@section('content')
@php
    $pendaftaran = $pemeriksaan->pendaftaran;
    $pasien = $pendaftaran?->pasien;
    $dokter = $pendaftaran?->jadwal?->dokter;
    $poli = $pendaftaran?->jadwal?->poli;
@endphp

<div class="detail-laporan-content">

    <div class="detail-laporan-card">
        <div class="detail-laporan-title">
            Detail Laporan Pemeriksaan
        </div>

        <div class="detail-laporan-grid">
            <div class="detail-laporan-item">
                <div class="detail-label">Nama Pasien</div>
                <div class="detail-value">{{ $pasien?->user?->name ?? '-' }}</div>
            </div>

            <div class="detail-laporan-item">
                <div class="detail-label">Email Pasien</div>
                <div class="detail-value">{{ $pasien?->user?->email ?? '-' }}</div>
            </div>

            <div class="detail-laporan-item">
                <div class="detail-label">Dokter</div>
                <div class="detail-value">{{ $dokter?->user?->name ?? '-' }}</div>
            </div>

            <div class="detail-laporan-item">
                <div class="detail-label">Poli</div>
                <div class="detail-value">{{ $poli?->nama_poli ?? '-' }}</div>
            </div>

            <div class="detail-laporan-item">
                <div class="detail-label">Tanggal Pemeriksaan</div>
                <div class="detail-value">
                    {{ $pemeriksaan->created_at ? $pemeriksaan->created_at->format('d/m/Y H:i') : '-' }}
                </div>
            </div>

            <div class="detail-laporan-item">
                <div class="detail-label">Nomor Antrian</div>
                <div class="detail-value">
                    {{ $pendaftaran->nomor_antrian ?? $pendaftaran->nomor_antrian ?? '-' }}
                </div>
            </div>

            <div class="detail-laporan-item full">
                <div class="detail-label">Keluhan</div>
                <div class="detail-value">{{ $pemeriksaan->keluhan ?? '-' }}</div>
            </div>

            <div class="detail-laporan-item full">
                <div class="detail-label">Diagnosa</div>
                <div class="detail-value">{{ $pemeriksaan->diagnosa ?? '-' }}</div>
            </div>

            <div class="detail-laporan-item full">
                <div class="detail-label">Resep</div>
                <div class="detail-value">{{ $pemeriksaan->resep ?? '-' }}</div>
            </div>

            <div class="detail-laporan-item full">
                <div class="detail-label">Resep Obat</div>
                <div class="detail-value">{{ $pemeriksaan->resep_obat ?? '-' }}</div>
            </div>

            <div class="detail-laporan-item full">
                <div class="detail-label">Catatan</div>
                <div class="detail-value">{{ $pemeriksaan->catatan ?? '-' }}</div>
            </div>
        </div>

        <div class="detail-laporan-actions">
            <a href="{{ route('admin.laporan.index') }}" class="detail-laporan-btn blue">
                Kembali
            </a>
        </div>
    </div>

</div>
@endsection
