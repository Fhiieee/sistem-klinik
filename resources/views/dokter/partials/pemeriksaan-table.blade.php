@forelse($pendaftarans ?? [] as $pendaftaran)
    <tr>
        <td>{{ $pendaftaran->pasien->user->name ?? '-' }}</td>
        <td>{{ $pendaftaran->jadwal->poli->nama_poli ?? '-' }}</td>
        <td>{{ $pendaftaran->tanggal_daftar ?? '-' }}</td>
        <td>{{ $pendaftaran->nomor_antrean ?? '-' }}</td>
        <td>
            <span class="dokter-status {{ $pendaftaran->status ?? 'menunggu' }}">
                {{ ucfirst($pendaftaran->status ?? '-') }}
            </span>
        </td>
        <td>
            <div class="dokter-action-cell">
                @if($pendaftaran->pemeriksaan)
                    <a href="{{ route('dokter.pemeriksaan.detail', $pendaftaran->pemeriksaan->id) }}" class="dokter-action-btn blue">
                        Detail
                    </a>
                @else
                    <a href="{{ route('dokter.pemeriksaan.create', $pendaftaran->id) }}" class="dokter-action-btn green">
                        Periksa
                    </a>
                @endif
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="dokter-empty">
            Belum ada pasien untuk diperiksa
        </td>
    </tr>
@endforelse
