@extends('layouts.app')

@section('layout-type', 'pasien')
@section('active-menu', 'pendaftaran')

@section('page-title', 'Daftar Pemeriksaan')
@section('page-subtitle', 'Pilih jadwal dokter untuk membuat pendaftaran')

@section('content')
<div class="pasien-form-pendaftaran-content">

    @if(session('error'))
        <div class="pasien-form-alert error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="pasien-form-alert error">
            <strong>Data belum valid.</strong>
            <div>Periksa kembali form pendaftaran Anda.</div>
        </div>
    @endif

    <div class="pasien-form-card">
        <div class="pasien-form-title">
            <div class="pasien-form-title-icon">
                <svg viewBox="0 0 64 64">
                    <path d="M32 12v40"></path>
                    <path d="M12 32h40"></path>
                </svg>
            </div>

            <div>
                <h2>Form Pendaftaran Pemeriksaan</h2>
                <p>Silakan pilih jadwal dokter dan tanggal pemeriksaan.</p>
            </div>
        </div>

        <form action="{{ route('pasien.pendaftaran.store') }}" method="POST" class="pasien-form-pendaftaran">
            @csrf

            <div class="pasien-form-section">
                <div class="pasien-section-label">Data Pasien</div>

                <div class="pasien-form-grid">
                    <div class="pasien-form-group">
                        <label>Nama Pasien</label>
                        <input type="text" value="{{ auth()->user()->name ?? '-' }}" disabled>
                    </div>

                    <div class="pasien-form-group">
                        <label>Email</label>
                        <input type="text" value="{{ auth()->user()->email ?? '-' }}" disabled>
                    </div>

                    <div class="pasien-form-group">
                        <label>NIK</label>
                        <input type="text" value="{{ $pasien->nik ?? '-' }}" disabled>
                    </div>

                    <div class="pasien-form-group">
                        <label>No. HP</label>
                        <input type="text" value="{{ $pasien->no_hp ?? '-' }}" disabled>
                    </div>
                </div>
            </div>

            <div class="pasien-form-section">
                <div class="pasien-section-label">Jadwal Pemeriksaan</div>

                <div class="pasien-form-grid">
                    <div class="pasien-form-group full">
                        <label>Pilih Jadwal Dokter</label>

                        <select name="jadwal_id" required>
                            <option value="">-- Pilih Jadwal --</option>

                            @foreach($jadwals ?? [] as $jadwal)
                                <option
                                    value="{{ $jadwal->id }}"
                                    {{ old('jadwal_id', $selectedJadwalId ?? '') == $jadwal->id ? 'selected' : '' }}
                                >
                                    {{ $jadwal->dokter->user->name ?? 'Dokter' }}
                                    -
                                    {{ $jadwal->poli->nama_poli ?? 'Poli' }}
                                    -
                                    {{ $jadwal->hari ?? '-' }}
                                    ({{ $jadwal->jam_mulai ?? '-' }} - {{ $jadwal->jam_selesai ?? '-' }})
                                </option>
                            @endforeach
                        </select>

                        @error('jadwal_id')
                            <div class="pasien-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pasien-form-group">
                        <label>Tanggal Daftar</label>

                        <input
                            type="date"
                            name="tanggal_daftar"
                            value="{{ old('tanggal_daftar', date('Y-m-d')) }}"
                            required
                        >

                        @error('tanggal_daftar')
                            <div class="pasien-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pasien-form-group">
                        <label>Status Awal</label>
                        <input type="text" value="Menunggu" disabled>
                    </div>
                </div>
            </div>

            <div class="pasien-form-actions">
                <a href="{{ route('pasien.pendaftaran.index') }}" class="pasien-form-btn yellow">
                    Kembali
                </a>

                <button type="submit" class="pasien-form-btn blue">
                    Simpan Pendaftaran
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
