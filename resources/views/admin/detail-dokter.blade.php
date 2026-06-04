@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Detail Dokter')
@section('page-subtitle', 'Lihat informasi lengkap dokter')
@section('active-menu', 'dokter')

@section('content')
<div class="detail-card">
    <div class="detail-title">Detail Dokter</div>

    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Nama Dokter</div>
            <div class="detail-value">{{ $dokter->user->name ?? '-' }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Email</div>
            <div class="detail-value">{{ $dokter->user->email ?? '-' }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Spesialis</div>
            <div class="detail-value">{{ $dokter->spesialis ?? '-' }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">No. SIP</div>
            <div class="detail-value">{{ $dokter->no_sip ?? '-' }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">No. HP</div>
            <div class="detail-value">{{ $dokter->no_hp ?? '-' }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Status</div>
            <div class="detail-value">
                {{ ucfirst($dokter->status ?? 'aktif') }}
            </div>
        </div>

        <div class="detail-item full">
            <div class="detail-label">Alamat</div>
            <div class="detail-value">{{ $dokter->alamat ?? '-' }}</div>
        </div>
    </div>

    <div class="detail-actions">
        <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="neo-btn yellow">
            Edit Dokter
        </a>

        <a href="{{ route('admin.dokter.index') }}" class="neo-btn blue">
            Kembali
        </a>
    </div>
</div>
@endsection
