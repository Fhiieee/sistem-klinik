@extends('layouts.app')
@section('layout-type', 'dokter')

@section('page-title', isset($pemeriksaan) ? 'Edit Pemeriksaan' : 'Tambah Pemeriksaan')
@section('page-subtitle', 'Input hasil pemeriksaan pasien')
@section('active-menu', 'pemeriksaan')

@section('content')
<div class="dokter-pemeriksaan-content">

    @if(session('error'))
        <div class="dokter-alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="dokter-alert-error">
            Data belum valid. Cek kembali isian form.
        </div>
    @endif

    <div class="dokter-form-card">
        <div class="dokter-form-title">
            <div class="dokter-form-title-icon">
                <svg viewBox="0 0 64 64">
                    <rect x="16" y="12" width="34" height="46" rx="3"></rect>
                    <path d="M25 12h16v-4H25z"></path>
                    <path d="M25 29h16M25 39h16M25 49h10"></path>
                </svg>
            </div>

            <div>
                <h2>{{ isset($pemeriksaan) ? 'Edit Pemeriksaan' : 'Tambah Pemeriksaan' }}</h2>
                <p>Isi keluhan, diagnosa, dan resep pasien.</p>
            </div>
        </div>

        @php
            $formAction = isset($pemeriksaan)
                ? route('dokter.pemeriksaan.update', $pemeriksaan->id)
                : route('dokter.pemeriksaan.store', $pendaftaran->id);
        @endphp

        <form action="{{ $formAction }}" method="POST">
            @csrf

            @if(isset($pemeriksaan))
                @method('PUT')
            @endif

            <div class="dokter-form-grid">
                <div class="dokter-form-group">
                    <label>Nama Pasien</label>
                    <input
                        type="text"
                        value="{{ $pendaftaran->pasien->user->name ?? '-' }}"
                        disabled
                    >
                </div>

                <div class="dokter-form-group">
                    <label>Poli</label>
                    <input
                        type="text"
                        value="{{ $pendaftaran->jadwal->poli->nama_poli ?? '-' }}"
                        disabled
                    >
                </div>

                <div class="dokter-form-group full">
                    <label>Keluhan</label>
                    <textarea name="keluhan" required>{{ old('keluhan', $pemeriksaan->keluhan ?? '') }}</textarea>

                    @error('keluhan')
                        <div class="dokter-form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="dokter-form-group full">
                    <label>Diagnosa</label>
                    <textarea name="diagnosa" required>{{ old('diagnosa', $pemeriksaan->diagnosa ?? '') }}</textarea>

                    @error('diagnosa')
                        <div class="dokter-form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="dokter-form-group full">
                    <label>Resep Obat</label>
                    <textarea name="resep">{{ old('resep', $pemeriksaan->resep ?? '') }}</textarea>

                    @error('resep')
                        <div class="dokter-form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="dokter-form-actions">
                <a href="{{ route('dokter.pemeriksaan.index') }}" class="dokter-form-btn yellow">
                    Kembali
                </a>

                <button type="submit" class="dokter-form-btn blue">
                    Simpan Pemeriksaan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
