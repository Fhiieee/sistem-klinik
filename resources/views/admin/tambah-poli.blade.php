@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Tambah Poli')
@section('page-subtitle', 'Tambahkan data poli klinik')
@section('active-menu', 'poli')

@section('content')
<div class="tambah-poli-content">

    @if(session('error'))
        <div class="poli-form-alert error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="poli-form-alert error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="poli-form-card">
        <div class="poli-form-title">
            <div class="poli-form-title-icon">
                <svg viewBox="0 0 64 64">
                    <rect x="14" y="24" width="36" height="30"></rect>
                    <path d="M25 24V12h14v12"></path>
                    <path d="M32 31v12M26 37h12"></path>
                    <path d="M20 54v-8h8v8M36 54v-8h8v8"></path>
                </svg>
            </div>

            <div>
                <h2>Form Tambah Poli</h2>
                <p>Isi data poli yang tersedia di klinik</p>
            </div>
        </div>

        <form action="{{ route('admin.poli.store') }}" method="POST" class="poli-form">
            @csrf

            <div class="poli-form-section">
                <div class="section-label">Data Poli</div>

                <div class="poli-form-grid">
                    <div class="poli-form-group">
                        <label for="nama_poli">Nama Poli</label>
                        <input
                            type="text"
                            id="nama_poli"
                            name="nama_poli"
                            value="{{ old('nama_poli') }}"
                            placeholder="Contoh: Poli Umum"
                        >

                        @error('nama_poli')
                            <div class="poli-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="poli-form-group full">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            placeholder="Contoh: Melayani pemeriksaan kesehatan umum"
                        >{{ old('deskripsi') }}</textarea>

                        @error('deskripsi')
                            <div class="poli-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="poli-form-actions">
                <button type="submit" class="poli-form-btn yellow">
                    <svg viewBox="0 0 64 64">
                        <path d="M16 10h26l8 8v36H16z"></path>
                        <path d="M24 10v16h18"></path>
                        <path d="M24 44h16"></path>
                    </svg>
                    Simpan Poli
                </button>

                <a href="{{ route('admin.poli.index') }}" class="poli-form-btn blue">
                    <svg viewBox="0 0 64 64">
                        <path d="M38 16L22 32l16 16"></path>
                        <path d="M24 32h28"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
