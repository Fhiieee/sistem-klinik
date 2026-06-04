@forelse($pasiens as $pasien)
    <tr>
        <td>{{ $pasien->user->name ?? '-' }}</td>
        <td>{{ $pasien->nik ?? '-' }}</td>
        <td>{{ $pasien->jenis_kelamin ?? '-' }}</td>
        <td>{{ $pasien->no_hp ?? '-' }}</td>
        <td>{{ $pasien->alamat ?? '-' }}</td>
        <td>
            <span class="status aktif">
                Aktif
            </span>
        </td>
        <td>
            <div class="action-cell">
                <a href="{{ route('admin.pasien.detail', $pasien->id) }}" class="action-btn blue">
                    Detail
                </a>

                <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="action-btn yellow">
                    Edit
                </a>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="empty">
            Data pasien tidak ditemukan
        </td>
    </tr>
@endforelse
