@forelse($dokters as $dokter)
    <tr>
        <td>{{ $dokter->user->name ?? '-' }}</td>
        <td>{{ $dokter->user->email ?? '-' }}</td>
        <td>{{ $dokter->spesialis ?? '-' }}</td>
        <td>{{ $dokter->no_sip ?? '-' }}</td>
        <td>{{ $dokter->no_hp ?? '-' }}</td>
        <td>
            <span class="status {{ $dokter->status == 'aktif' ? 'aktif' : 'nonaktif' }}">
                {{ ucfirst($dokter->status ?? '-') }}
            </span>
        </td>
        <td>
            <div class="action-cell">
                <a href="{{ route('admin.dokter.detail', $dokter->id) }}" class="action-btn blue">
                    Detail
                </a>

                <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="action-btn yellow">
                    Edit
                </a>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="empty">
            Data dokter tidak ditemukan
        </td>
    </tr>
@endforelse
