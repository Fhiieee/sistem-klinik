@extends('layouts.app')
@section('layout-type', 'admin')

@section('page-title', 'Edit Jadwal')
@section('page-subtitle', 'Perbarui jadwal praktik dokter')
@section('active-menu', 'jadwal')

@section('content')
<div class="tambah-jadwal-content">

    @if(session('error'))
        <div class="jadwal-form-alert error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="jadwal-form-alert error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="jadwal-form-card">
        <div class="jadwal-form-title">
            <div class="jadwal-form-title-icon">
                <svg viewBox="0 0 64 64">
                    <rect x="10" y="14" width="44" height="42"></rect>
                    <path d="M20 8v12M44 8v12M10 26h44"></path>
                </svg>
            </div>

            <div>
                <h2>Edit Jadwal Dokter</h2>
                <p>Perbarui data jadwal praktik dokter klinik</p>
            </div>
        </div>

        <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST" class="jadwal-form">
            @csrf
            @method('PUT')

            <div class="jadwal-form-section">
                <div class="section-label">Data Jadwal</div>

                <div class="jadwal-form-grid">
                    <div class="jadwal-form-group">
                        <label>Dokter</label>
                        <select name="dokter_id">
                            <option value="">Pilih Dokter</option>
                            @foreach($dokters as $dokter)
                                <option value="{{ $dokter->id }}" {{ old('dokter_id', $jadwal->dokter_id) == $dokter->id ? 'selected' : '' }}>
                                    {{ $dokter->user->name ?? '-' }} - {{ $dokter->spesialis ?? '-' }}
                                </option>
                            @endforeach
                        </select>

                        @error('dokter_id')
                            <div class="jadwal-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="jadwal-form-group">
                        <label>Poli</label>
                        <select name="poli_id">
                            <option value="">Pilih Poli</option>
                            @foreach($polis as $poli)
                                <option value="{{ $poli->id }}" {{ old('poli_id', $jadwal->poli_id) == $poli->id ? 'selected' : '' }}>
                                    {{ $poli->nama_poli }}
                                </option>
                            @endforeach
                        </select>

                        @error('poli_id')
                            <div class="jadwal-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="jadwal-form-group">
                        <label>Hari</label>
                        <select name="hari">
                            <option value="">Pilih Hari</option>
                            <option value="Senin" {{ old('hari', $jadwal->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                            <option value="Selasa" {{ old('hari', $jadwal->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                            <option value="Rabu" {{ old('hari', $jadwal->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                            <option value="Kamis" {{ old('hari', $jadwal->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                            <option value="Jumat" {{ old('hari', $jadwal->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                            <option value="Sabtu" {{ old('hari', $jadwal->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                            <option value="Minggu" {{ old('hari', $jadwal->hari) == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                        </select>

                        @error('hari')
                            <div class="jadwal-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="jadwal-form-group">
                        <label>Jam Mulai</label>
                        <input
                            type="time"
                            name="jam_mulai"
                            value="{{ old('jam_mulai', \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')) }}"
                        >

                        @error('jam_mulai')
                            <div class="jadwal-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="jadwal-form-group">
                        <label>Jam Selesai</label>
                        <input
                            type="time"
                            name="jam_selesai"
                            value="{{ old('jam_selesai', \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i')) }}"
                        >

                        @error('jam_selesai')
                            <div class="jadwal-form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="jadwal-form-actions">
                <button type="submit" class="jadwal-form-btn yellow">
                    Simpan
                </button>

                <a href="{{ route('admin.jadwal.index') }}" class="jadwal-form-btn blue">
                    Kembali
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
