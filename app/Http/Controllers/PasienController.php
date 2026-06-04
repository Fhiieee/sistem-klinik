<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    private function checkPasien()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'pasien') {
            return redirect()->route('login')->with('error', 'Akses khusus pasien!');
        }

        return null;
    }

    private function getPasien()
    {
        return Pasien::with('user')
            ->where('user_id', Auth::id())
            ->first();
    }

    public function dashboard()
    {
        if ($redirect = $this->checkPasien()) {
            return $redirect;
        }

        $pasien = $this->getPasien();

        if (!$pasien) {
            return redirect()->route('login')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        $totalPendaftaran = Pendaftaran::where('pasien_id', $pasien->id)->count();

        $pendaftaranMenunggu = Pendaftaran::where('pasien_id', $pasien->id)
            ->where('status', 'menunggu')
            ->count();

        $pemeriksaanSelesai = Pemeriksaan::whereHas('pendaftaran', function ($query) use ($pasien) {
                $query->where('pasien_id', $pasien->id);
            })
            ->count();

        $pendaftaranTerbaru = Pendaftaran::with([
                'jadwal.dokter.user',
                'jadwal.poli',
            ])
            ->where('pasien_id', $pasien->id)
            ->latest()
            ->take(5)
            ->get();

        return view('pasien.dashboard', compact(
            'pasien',
            'totalPendaftaran',
            'pendaftaranMenunggu',
            'pemeriksaanSelesai',
            'pendaftaranTerbaru'
        ));
    }

    public function jadwal(Request $request)
    {
        if ($redirect = $this->checkPasien()) {
            return $redirect;
        }

        $search = $request->search;

        $jadwals = \App\Models\Jadwal::with([
                'dokter.user',
                'poli',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where('hari', 'like', '%' . $search . '%')
                    ->orWhere('jam_mulai', 'like', '%' . $search . '%')
                    ->orWhere('jam_selesai', 'like', '%' . $search . '%')
                    ->orWhereHas('dokter.user', function ($dokterQuery) use ($search) {
                        $dokterQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('poli', function ($poliQuery) use ($search) {
                        $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        $totalJadwal = \App\Models\Jadwal::count();
        $totalDokter = \App\Models\Dokter::count();
        $totalPoli = \App\Models\Poli::count();

        return view('pasien.jadwal', compact(
            'jadwals',
            'totalJadwal',
            'totalDokter',
            'totalPoli',
            'search'
        ));
    }

    public function pendaftaran(Request $request)
    {
        if ($redirect = $this->checkPasien()) {
            return $redirect;
        }

        $pasien = $this->getPasien();

        if (!$pasien) {
            return redirect()->route('login')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        $search = $request->search;

        $pendaftarans = \App\Models\Pendaftaran::with([
                'jadwal.dokter.user',
                'jadwal.poli',
            ])
            ->where('pasien_id', $pasien->id)
            ->when($search, function ($query) use ($search) {
                $query->where('nomor_antrian', 'like', '%' . $search . '%')
                    ->orWhere('nomor_antrean', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereDate('tanggal_daftar', $search)
                    ->orWhereHas('jadwal.dokter.user', function ($dokterQuery) use ($search) {
                        $dokterQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jadwal.poli', function ($poliQuery) use ($search) {
                        $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        $totalPendaftaran = \App\Models\Pendaftaran::where('pasien_id', $pasien->id)->count();

        $pendaftaranMenunggu = \App\Models\Pendaftaran::where('pasien_id', $pasien->id)
            ->where('status', 'menunggu')
            ->count();

        $pendaftaranSelesai = \App\Models\Pendaftaran::where('pasien_id', $pasien->id)
            ->where('status', 'selesai')
            ->count();

        return view('pasien.pendaftaran', compact(
            'pasien',
            'pendaftarans',
            'totalPendaftaran',
            'pendaftaranMenunggu',
            'pendaftaranSelesai',
            'search'
        ));
    }

    public function createPendaftaran(Request $request)
    {
        if ($redirect = $this->checkPasien()) {
            return $redirect;
        }

        $pasien = $this->getPasien();

        if (!$pasien) {
            return redirect()->route('login')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        $jadwals = \App\Models\Jadwal::with([
                'dokter.user',
                'poli',
            ])
            ->latest()
            ->get();

        $selectedJadwalId = $request->jadwal_id;

        return view('pasien.form-pendaftaran', compact(
            'pasien',
            'jadwals',
            'selectedJadwalId'
        ));
    }

    public function storePendaftaran(Request $request)
    {
        if ($redirect = $this->checkPasien()) {
            return $redirect;
        }

        $pasien = $this->getPasien();

        if (!$pasien) {
            return redirect()->route('login')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'tanggal_daftar' => 'required|date',
        ], [
            'jadwal_id.required' => 'Jadwal dokter wajib dipilih.',
            'jadwal_id.exists' => 'Jadwal dokter tidak valid.',
            'tanggal_daftar.required' => 'Tanggal daftar wajib diisi.',
            'tanggal_daftar.date' => 'Format tanggal tidak valid.',
        ]);

        $nomorAntreanTerakhir = \App\Models\Pendaftaran::where('jadwal_id', $request->jadwal_id)
            ->whereDate('tanggal_daftar', $request->tanggal_daftar)
            ->max('nomor_antrean');

        if ($nomorAntreanTerakhir === null) {
            $nomorAntreanTerakhir = \App\Models\Pendaftaran::where('jadwal_id', $request->jadwal_id)
                ->whereDate('tanggal_daftar', $request->tanggal_daftar)
                ->max('nomor_antrian');
        }

        $nomorAntreanBaru = ((int) $nomorAntreanTerakhir) + 1;

        $data = [
            'pasien_id' => $pasien->id,
            'jadwal_id' => $request->jadwal_id,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status' => 'menunggu',
        ];

        if (\Illuminate\Support\Facades\Schema::hasColumn('pendaftarans', 'nomor_antrean')) {
            $data['nomor_antrean'] = $nomorAntreanBaru;
        } else {
            $data['nomor_antrian'] = $nomorAntreanBaru;
        }

        \App\Models\Pendaftaran::create($data);

        return redirect()
            ->route('pasien.pendaftaran.index')
            ->with('success', 'Pendaftaran pemeriksaan berhasil dibuat!');
    }

    public function riwayat(Request $request)
    {
        if ($redirect = $this->checkPasien()) {
            return $redirect;
        }

        $pasien = $this->getPasien();

        if (!$pasien) {
            return redirect()->route('login')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        $search = $request->search;

        $pemeriksaans = \App\Models\Pemeriksaan::with([
                'pendaftaran.jadwal.dokter.user',
                'pendaftaran.jadwal.poli',
            ])
            ->whereHas('pendaftaran', function ($query) use ($pasien) {
                $query->where('pasien_id', $pasien->id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('keluhan', 'like', '%' . $search . '%')
                    ->orWhere('diagnosa', 'like', '%' . $search . '%')
                    ->orWhere('resep', 'like', '%' . $search . '%')
                    ->orWhereHas('pendaftaran.jadwal.dokter.user', function ($dokterQuery) use ($search) {
                        $dokterQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('pendaftaran.jadwal.poli', function ($poliQuery) use ($search) {
                        $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        $totalPemeriksaan = \App\Models\Pemeriksaan::whereHas('pendaftaran', function ($query) use ($pasien) {
                $query->where('pasien_id', $pasien->id);
            })
            ->count();

        $pemeriksaanHariIni = \App\Models\Pemeriksaan::whereHas('pendaftaran', function ($query) use ($pasien) {
                $query->where('pasien_id', $pasien->id);
            })
            ->whereDate('created_at', now()->toDateString())
            ->count();

        $totalPendaftaran = \App\Models\Pendaftaran::where('pasien_id', $pasien->id)->count();

        return view('pasien.riwayat', compact(
            'pasien',
            'pemeriksaans',
            'totalPemeriksaan',
            'pemeriksaanHariIni',
            'totalPendaftaran',
            'search'
        ));
    }

    public function profile()
    {
        if ($redirect = $this->checkPasien()) {
            return $redirect;
        }

        $pasien = $this->getPasien();

        return view('pasien.profile', compact('pasien'));
    }

    public function updateProfile(Request $request)
    {
        if ($redirect = $this->checkPasien()) {
            return $redirect;
        }

        $pasien = $this->getPasien();

        if (!$pasien) {
            return redirect()->route('login')
                ->with('error', 'Data pasien tidak ditemukan.');
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'nik' => 'required|digits:16|unique:pasiens,nik,' . $pasien->id,
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $pasien->update([
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return back()->with('success', 'Profil pasien berhasil diperbarui!');
    }
}
