@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Tambah Dokter')
@section('page-subtitle', 'Tambahkan data dokter dan akun login dokter')
@section('active-menu', 'dokter')

@section('content')
<div class="tambah-dokter-content">

    @if(session('error'))
        <div class="doctor-form-alert error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="doctor-form-alert error">
            Data dokter belum valid. Periksa kembali form yang kamu isi.
        </div>
    @endif

    <div class="doctor-form-card">

        <div class="doctor-form-title">
            <div class="doctor-form-title-icon">
                <svg viewBox="0 0 64 64">
                    <circle cx="32" cy="17" r="10"></circle>
                    <path d="M16 58c3-17 11-27 16-27s13 10 16 27"></path>
                    <path d="M24 36l8 10 8-10"></path>
                    <circle cx="45" cy="50" r="5"></circle>
                </svg>
            </div>

            <div>
                <h2>Form Tambah Dokter</h2>
                <p>Isi data akun dan identitas dokter</p>
            </div>
        </div>

        <form action="{{ route('admin.dokter.store') }}" method="POST" class="doctor-form">
            @csrf

            <div class="doctor-form-section">
                <div class="section-label">Data Akun</div>

                <div class="doctor-form-grid">
                    <div class="doctor-form-group">
                        <label for="name">Nama Lengkap</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama dokter"
                        >

                        @error('name')
                            <div class="doctor-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="doctor-form-group">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email dokter"
                        >

                        @error('email')
                            <div class="doctor-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="doctor-form-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Minimal 6 karakter"
                        >

                        @error('password')
                            <div class="doctor-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="doctor-form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="Ulangi password"
                        >
                    </div>
                </div>
            </div>

            <div class="doctor-form-section">
                <div class="section-label">Data Dokter</div>

                <div class="doctor-form-grid">
                    <div class="doctor-form-group">
                        <label for="spesialis">Spesialis</label>
                        <input
                            type="text"
                            name="spesialis"
                            id="spesialis"
                            value="{{ old('spesialis') }}"
                            placeholder="Contoh: Dokter Umum"
                        >

                        @error('spesialis')
                            <div class="doctor-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="doctor-form-group">
                        <label for="no_sip">No. SIP</label>
                        <input
                            type="text"
                            name="no_sip"
                            id="no_sip"
                            value="{{ old('no_sip') }}"
                            placeholder="Masukkan nomor SIP"
                        >

                        @error('no_sip')
                            <div class="doctor-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="doctor-form-group">
                        <label for="no_hp">No. HP</label>
                        <input
                            type="text"
                            name="no_hp"
                            id="no_hp"
                            value="{{ old('no_hp') }}"
                            placeholder="Contoh: 081234567890"
                        >

                        @error('no_hp')
                            <div class="doctor-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="doctor-form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="">Pilih status</option>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>

                        @error('status')
                            <div class="doctor-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="doctor-form-group full">
                        <label for="alamat">Alamat</label>
                        <textarea
                            name="alamat"
                            id="alamat"
                            placeholder="Masukkan alamat dokter"
                        >{{ old('alamat') }}</textarea>

                        @error('alamat')
                            <div class="doctor-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="doctor-form-actions">
                <button type="submit" class="doctor-form-btn yellow">
                    <svg viewBox="0 0 64 64">
                        <path d="M12 10h34l8 8v36H12z"></path>
                        <path d="M20 10v16h24V10"></path>
                        <path d="M20 54V36h24v18"></path>
                    </svg>
                    Simpan Dokter
                </button>

                <a href="{{ route('admin.dokter.index') }}" class="doctor-form-btn blue">
                    <svg viewBox="0 0 64 64">
                        <path d="M38 14L20 32l18 18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </form>

    </div>
</div>
@endsection
