@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Detail Pasien')
@section('page-subtitle', 'Informasi lengkap data pasien')
@section('active-menu', 'pasien')

@section('content')
<div class="detail-card">
    <div class="detail-title">Detail Pasien</div>

    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Nama</div>
            <div class="detail-value">{{ $pasien->user->name }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Email</div>
            <div class="detail-value">{{ $pasien->user->email }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">NIK</div>
            <div class="detail-value">{{ $pasien->nik }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Tanggal Lahir</div>
            <div class="detail-value">{{ $pasien->tanggal_lahir }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Jenis Kelamin</div>
            <div class="detail-value">{{ $pasien->jenis_kelamin }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">No HP</div>
            <div class="detail-value">{{ $pasien->no_hp }}</div>
        </div>

        <div class="detail-item full">
            <div class="detail-label">Alamat</div>
            <div class="detail-value">{{ $pasien->alamat }}</div>
        </div>
    </div>

    <div class="detail-actions">
        <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="neo-btn yellow">Edit</a>
        <a href="{{ route('admin.pasien.index') }}" class="neo-btn blue">Kembali</a>
    </div>
</div>
@endsection
