@forelse($jadwals as $jadwal)
    <tr>
        <td>{{ $jadwal->hari ?? '-' }}</td>
        <td>{{ $jadwal->jam_mulai ?? '-' }}</td>
        <td>{{ $jadwal->jam_selesai ?? '-' }}</td>
        <td>{{ $jadwal->poli->nama_poli ?? '-' }}</td>
        <td>{{ $jadwal->dokter->user->name ?? '-' }}</td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="empty">
            Belum ada jadwal dokter
        </td>
    </tr>
@endforelse
