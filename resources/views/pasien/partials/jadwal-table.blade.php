@forelse($jadwals as $jadwal)
    <tr>
        <td>{{ $jadwal->dokter->user->name ?? '-' }}</td>
        <td>{{ $jadwal->poli->nama_poli ?? '-' }}</td>
        <td>{{ $jadwal->hari ?? '-' }}</td>
        <td>{{ $jadwal->jam_mulai ?? '-' }}</td>
        <td>{{ $jadwal->jam_selesai ?? '-' }}</td>
        <td>
            <a href="{{ route('pasien.pendaftaran.create', ['jadwal_id' => $jadwal->id]) }}" class="pasien-jadwal-action-btn">
                Daftar
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="pasien-jadwal-empty">
            Belum ada jadwal dokter
        </td>
    </tr>
@endforelse
