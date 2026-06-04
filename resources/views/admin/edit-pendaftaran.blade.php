@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Edit Pendaftaran')
@section('page-subtitle', 'Perbarui data pendaftaran pasien')
@section('active-menu', 'pendaftaran')

@section('content')
<div class="tambah-pendaftaran-content">

    @if ($errors->any())
        <div class="pendaftaran-form-alert error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="pendaftaran-form-card">
        <div class="pendaftaran-form-title">
            <div class="pendaftaran-form-title-icon">
                <svg viewBox="0 0 64 64">
                    <rect x="16" y="12" width="34" height="46"></rect>
                    <path d="M25 12h16v-4H25z"></path>
                    <path d="M25 29h16M25 39h16M25 49h10"></path>
                </svg>
            </div>

            <div>
                <h2>Edit Pendaftaran</h2>
                <p>Perbarui data pendaftaran pasien</p>
            </div>
        </div>

        <form action="{{ route('admin.pendaftaran.update', $pendaftaran->id) }}" method="POST" class="pendaftaran-form">
            @csrf
            @method('PUT')

            <div class="pendaftaran-form-section">
                <div class="section-label">Data Pendaftaran</div>

                <div class="pendaftaran-form-grid">
                    <div class="pendaftaran-form-group">
                        <label>Pasien</label>
                        <select name="pasien_id">
                            <option value="">Pilih Pasien</option>
                            @foreach($pasiens as $pasien)
                                <option value="{{ $pasien->id }}" {{ old('pasien_id', $pendaftaran->pasien_id) == $pasien->id ? 'selected' : '' }}>
                                    {{ $pasien->user->name ?? '-' }} - {{ $pasien->nik ?? '-' }}
                                </option>
                            @endforeach
                        </select>

                        @error('pasien_id')
                            <div class="pendaftaran-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pendaftaran-form-group">
                        <label>Jadwal Dokter</label>
                        <select name="jadwal_id">
                            <option value="">Pilih Jadwal</option>
                            @foreach($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}" {{ old('jadwal_id', $pendaftaran->jadwal_id) == $jadwal->id ? 'selected' : '' }}>
                                    {{ $jadwal->dokter->user->name ?? '-' }}
                                    -
                                    {{ $jadwal->poli->nama_poli ?? '-' }}
                                    -
                                    {{ $jadwal->hari }}
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                    s/d
                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                </option>
                            @endforeach
                        </select>

                        @error('jadwal_id')
                            <div class="pendaftaran-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pendaftaran-form-group">
                        <label>Tanggal Daftar</label>
                        <input
                            type="date"
                            name="tanggal_daftar"
                            value="{{ old('tanggal_daftar', \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->format('Y-m-d')) }}"
                        >

                        @error('tanggal_daftar')
                            <div class="pendaftaran-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pendaftaran-form-group">
                        <label>Nomor Antrean</label>
                        <input
                            type="number"
                            name="nomor_antrian"
                            value="{{ old('nomor_antrian', $pendaftaran->nomor_antrian) }}"
                        >

                        @error('nomor_antrian')
                            <div class="pendaftaran-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pendaftaran-form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="menunggu" {{ old('status', $pendaftaran->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diperiksa" {{ old('status', $pendaftaran->status) == 'diperiksa' ? 'selected' : '' }}>Diperiksa</option>
                            <option value="selesai" {{ old('status', $pendaftaran->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="batal" {{ old('status', $pendaftaran->status) == 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>

                        @error('status')
                            <div class="pendaftaran-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pendaftaran-form-actions">
                <button type="submit" class="pendaftaran-form-btn yellow">
                    Simpan
                </button>

                <a href="{{ route('admin.pendaftaran.index') }}" class="pendaftaran-form-btn blue">
                    Kembali
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
