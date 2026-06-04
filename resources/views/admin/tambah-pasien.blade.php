@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Tambah Pasien')
@section('page-subtitle', 'Tambahkan data pasien baru')
@section('active-menu', 'pasien')

@section('content')
<div class="tambah-pasien-content">

    @if(session('error'))
        <div class="patient-form-alert error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="patient-form-alert error">
            <div>Data pasien belum valid.</div>
        </div>
    @endif

    <div class="patient-form-card">
        <div class="patient-form-title">
            <div class="patient-form-title-icon">
                <svg viewBox="0 0 64 64">
                    <circle cx="29" cy="23" r="12"></circle>
                    <path d="M9 56c3-14 13-22 20-22s17 8 20 22"></path>
                    <path d="M49 18v18M40 27h18"></path>
                </svg>
            </div>

            <div>
                <h2>Form Tambah Pasien</h2>
                <p>Isi data akun dan identitas pasien</p>
            </div>
        </div>

        <form action="{{ route('admin.pasien.store') }}" method="POST" class="patient-form">
            @csrf

            <div class="patient-form-section">
                <div class="section-label">Data Akun</div>

                <div class="patient-form-grid">
                    <div class="patient-form-group">
                        <label for="name">Nama Lengkap</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                        >

                        @error('name')
                            <div class="patient-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="patient-form-group">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email pasien"
                        >

                        @error('email')
                            <div class="patient-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="patient-form-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Minimal 6 karakter"
                        >

                        @error('password')
                            <div class="patient-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="patient-form-group">
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

            <div class="patient-form-section">
                <div class="section-label">Data Pasien</div>

                <div class="patient-form-grid">
                    <div class="patient-form-group">
                        <label for="nik">NIK</label>
                        <input
                            type="text"
                            name="nik"
                            id="nik"
                            value="{{ old('nik') }}"
                            placeholder="16 digit NIK"
                            maxlength="16"
                        >

                        @error('nik')
                            <div class="patient-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="patient-form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input
                            type="date"
                            name="tanggal_lahir"
                            id="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}"
                        >

                        @error('tanggal_lahir')
                            <div class="patient-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="patient-form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin">
                            <option value="">Pilih jenis kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>

                        @error('jenis_kelamin')
                            <div class="patient-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="patient-form-group">
                        <label for="no_hp">No. HP</label>
                        <input
                            type="text"
                            name="no_hp"
                            id="no_hp"
                            value="{{ old('no_hp') }}"
                            placeholder="Contoh: 081234567890"
                        >

                        @error('no_hp')
                            <div class="patient-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="patient-form-group full">
                        <label for="alamat">Alamat</label>
                        <textarea
                            name="alamat"
                            id="alamat"
                            placeholder="Masukkan alamat pasien"
                        >{{ old('alamat') }}</textarea>

                        @error('alamat')
                            <div class="patient-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="patient-form-actions">
                <button type="submit" class="patient-form-btn yellow">
                    <svg viewBox="0 0 64 64">
                        <path d="M12 10h34l8 8v36H12z"></path>
                        <path d="M20 10v16h24V10"></path>
                        <path d="M20 54V36h24v18"></path>
                    </svg>
                    Simpan Pasien
                </button>

                <a href="{{ route('admin.pasien.index') }}" class="patient-form-btn blue">
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
