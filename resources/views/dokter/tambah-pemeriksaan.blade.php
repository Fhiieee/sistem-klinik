@extends('layouts.app')

@section('layout-type', 'dokter')
@section('active-menu', 'pemeriksaan')

@section('page-title', 'Tambah Pemeriksaan')
@section('page-subtitle', 'Input hasil pemeriksaan pasien')

@section('content')
<div class="dokter-form-pemeriksaan-content">

    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            Data belum valid. Periksa kembali form pemeriksaan.
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
                <h2>Form Pemeriksaan Pasien</h2>
                <p>Isi keluhan, diagnosa, dan resep pasien.</p>
            </div>
        </div>

        <div class="dokter-pasien-info">
            <div class="info-box">
                <div class="info-label">Nama Pasien</div>
                <div class="info-value">{{ $pendaftaran->pasien->user->name ?? '-' }}</div>
            </div>

            <div class="info-box">
                <div class="info-label">Poli</div>
                <div class="info-value">{{ $pendaftaran->jadwal->poli->nama_poli ?? '-' }}</div>
            </div>

            <div class="info-box">
                <div class="info-label">Tanggal Daftar</div>
                <div class="info-value">{{ $pendaftaran->tanggal_daftar ?? '-' }}</div>
            </div>

            <div class="info-box">
                <div class="info-label">No. Antrean</div>
                <div class="info-value">{{ $pendaftaran->nomor_antrean ?? '-' }}</div>
            </div>
        </div>

        <form action="{{ route('dokter.pemeriksaan.store', $pendaftaran->id) }}" method="POST" class="dokter-form-pemeriksaan">
            @csrf

            <div class="dokter-form-group">
                <label>Keluhan</label>
                <textarea name="keluhan" placeholder="Masukkan keluhan pasien...">{{ old('keluhan') }}</textarea>

                @error('keluhan')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="dokter-form-group">
                <label>Diagnosa</label>
                <textarea name="diagnosa" placeholder="Masukkan diagnosa dokter...">{{ old('diagnosa') }}</textarea>

                @error('diagnosa')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="dokter-form-group">
                <label>Resep</label>
                <textarea name="resep" placeholder="Masukkan resep obat...">{{ old('resep') }}</textarea>

                @error('resep')
                    <div class="form-error">{{ $message }}</div>
                @enderror
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
