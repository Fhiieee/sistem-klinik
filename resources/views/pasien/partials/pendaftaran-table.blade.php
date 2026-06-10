@forelse($pendaftarans as $pendaftaran)
    <tr>
        <td>{{ $pendaftaran->jadwal->dokter->user->name ?? '-' }}</td>
        <td>{{ $pendaftaran->jadwal->poli->nama_poli ?? '-' }}</td>
        <td>{{ $pendaftaran->jadwal->hari ?? '-' }}</td>
        <td>{{ $pendaftaran->tanggal_daftar ?? '-' }}</td>
        <td>{{ $pendaftaran->nomor_antrean ?? '-' }}</td>
        <td>
            <span class="status {{ $pendaftaran->status ?? 'menunggu' }}">
                {{ ucfirst($pendaftaran->status ?? 'menunggu') }}
            </span>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="pasien-pendaftaran-empty">
            Belum ada data pendaftaran
        </td>
    </tr>
@endforelse
