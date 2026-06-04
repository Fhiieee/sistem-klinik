<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Akses khusus admin!');
        }

        return null;
    }

    public function dashboard()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $totalPasien = Pasien::count();
        $totalDokter = Dokter::count();
        $totalPoli = Poli::count();
        $totalUser = User::count();

        $pendaftaranHariIni = Pendaftaran::whereDate('tanggal_daftar', now()->toDateString())->count();

        $pemeriksaanSelesai = Pemeriksaan::count();

        $pendaftaranTerbaru = Pendaftaran::with([
            'pasien.user',
            'jadwal.dokter.user',
            'jadwal.poli',
        ])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'totalPoli',
            'totalUser',
            'pendaftaranHariIni',
            'pemeriksaanSelesai',
            'pendaftaranTerbaru'
        ));
    }

    public function profile()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success_profile', 'Profil admin berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah.',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success_password', 'Password admin berhasil diubah!');
    }

    public function pasien(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $search = $request->search;

        $pasiens = Pasien::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('nik', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        $totalPasien = Pasien::count();

        $pasienBaruHariIni = Pasien::whereDate('created_at', now()->toDateString())->count();

        return view('admin.data-pasien', compact(
            'pasiens',
            'totalPasien',
            'pasienBaruHariIni',
            'search'
        ));
    }

    public function createPasien()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        return view('admin.tambah-pasien');
    }

    public function searchPasienAjax(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $search = $request->search;

        $pasiens = Pasien::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('nik', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhere('jenis_kelamin', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        $html = view('admin.partials.pasien-table', compact('pasiens'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }

    public function storePasien(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'nik' => 'required|digits:16|unique:pasiens,nik',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
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

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien',
            ]);

            Pasien::create([
                'user_id' => $user->id,
                'nik' => $request->nik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.pasien.index')
                ->with('success', 'Data pasien berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Data pasien gagal ditambahkan.');
        }
    }

    public function detailPasien($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $pasien = Pasien::with('user')->findOrFail($id);

        return view('admin.detail-pasien', compact('pasien'));
    }

    public function editPasien($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $pasien = Pasien::with('user')->findOrFail($id);

        return view('admin.edit-pasien', compact('pasien'));
    }

    public function updatePasien(Request $request, $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $pasien = Pasien::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|unique:pasiens,nik,' . $pasien->id,
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $pasien->user_id,
        ]);

        $pasien->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $pasien->update([
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()
            ->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function dokter(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $search = $request->search;

        $dokters = Dokter::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('spesialis', 'like', '%' . $search . '%')
                    ->orWhere('no_sip', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        $totalDokter = Dokter::count();

        $dokterAktif = Dokter::where('status', 'aktif')->count();

        $jadwalAktif = Jadwal::count();

        return view('admin.data-dokter', compact(
            'dokters',
            'totalDokter',
            'dokterAktif',
            'jadwalAktif',
            'search'
        ));
    }

    public function createDokter()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        return view('admin.tambah-dokter');
    }

    public function searchDokterAjax(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $search = $request->search;

        $dokters = Dokter::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('spesialis', 'like', '%' . $search . '%')
                    ->orWhere('no_sip', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        $html = view('admin.partials.dokter-table', compact('dokters'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }

    public function storeDokter(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'spesialis' => 'required|string|max:255',
            'no_sip' => 'required|string|max:100|unique:dokters,no_sip',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'dokter',
            ]);

            Dokter::create([
                'user_id' => $user->id,
                'spesialis' => $request->spesialis,
                'no_sip' => $request->no_sip,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.dokter.index')
                ->with('success', 'Data dokter berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Data dokter gagal ditambahkan.');
        }
    }

    public function detailDokter($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $dokter = Dokter::with('user')->findOrFail($id);

        return view('admin.detail-dokter', compact('dokter'));
    }

    public function editDokter($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $dokter = Dokter::with('user')->findOrFail($id);

        return view('admin.edit-dokter', compact('dokter'));
    }

    public function updateDokter(Request $request, $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $dokter = Dokter::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $dokter->user_id,
            'spesialis' => 'required|string|max:255',
            'no_sip' => 'required|string|max:100|unique:dokters,no_sip,' . $dokter->id,
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama dokter wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'spesialis.required' => 'Spesialis wajib diisi.',
            'no_sip.required' => 'No. SIP wajib diisi.',
            'no_sip.unique' => 'No. SIP sudah digunakan.',
            'no_hp.required' => 'No. HP wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        DB::beginTransaction();

        try {
            $dokter->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $dokter->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $dokter->update([
                'spesialis' => $request->spesialis,
                'no_sip' => $request->no_sip,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.dokter.index')
                ->with('success', 'Data dokter berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Data dokter gagal diperbarui.');
        }
    }

    public function poli(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $search = $request->search;

        $polis = Poli::when($search, function ($query) use ($search) {
            $query->where('nama_poli', 'like', '%' . $search . '%')
                ->orWhere('deskripsi', 'like', '%' . $search . '%');
        })
            ->latest()
            ->get();

        $totalPoli = Poli::count();

        return view('admin.data-poli', compact(
            'polis',
            'totalPoli',
            'search'
        ));
    }

    public function searchPoliAjax(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $search = $request->search;

        $polis = Poli::when($search, function ($query) use ($search) {
                $query->where('nama_poli', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            })
            ->latest()
            ->get();

        $html = view('admin.partials.poli-table', compact('polis'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }

    public function createPoli()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        return view('admin.tambah-poli');
    }

    public function storePoli(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $request->validate([
            'nama_poli' => 'required|string|max:255|unique:polis,nama_poli',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_poli.required' => 'Nama poli wajib diisi.',
            'nama_poli.unique' => 'Nama poli sudah terdaftar.',
            'nama_poli.max' => 'Nama poli maksimal 255 karakter.',
        ]);

        Poli::create([
            'nama_poli' => $request->nama_poli,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.poli.index')
            ->with('success', 'Data poli berhasil ditambahkan!');
    }

    public function editPoli($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $poli = Poli::findOrFail($id);

        return view('admin.edit-poli', compact('poli'));
    }

    public function updatePoli(Request $request, $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $poli = Poli::findOrFail($id);

        $request->validate([
            'nama_poli' => 'required|string|max:255|unique:polis,nama_poli,' . $poli->id,
            'deskripsi' => 'nullable|string',
        ], [
            'nama_poli.required' => 'Nama poli wajib diisi.',
            'nama_poli.unique' => 'Nama poli sudah terdaftar.',
            'nama_poli.max' => 'Nama poli maksimal 255 karakter.',
        ]);

        $poli->update([
            'nama_poli' => $request->nama_poli,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.poli.index')
            ->with('success', 'Data poli berhasil diperbarui!');
    }

    public function destroyPoli($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $poli = Poli::findOrFail($id);

        $poli->delete();

        return redirect()
            ->route('admin.poli.index')
            ->with('success', 'Data poli berhasil dihapus!');
    }

    public function jadwal(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $search = $request->search;

        $jadwals = Jadwal::with([
            'dokter.user',
            'poli',
        ])
            ->when($search, function ($query) use ($search) {
                $query->where('hari', 'like', '%' . $search . '%')
                    ->orWhere('jam_mulai', 'like', '%' . $search . '%')
                    ->orWhere('jam_selesai', 'like', '%' . $search . '%')
                    ->orWhereHas('dokter.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('poli', function ($poliQuery) use ($search) {
                        $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        $totalJadwal = Jadwal::count();

        $totalDokter = Dokter::count();

        $totalPoli = Poli::count();

        return view('admin.data-jadwal', compact(
            'jadwals',
            'totalJadwal',
            'totalDokter',
            'totalPoli',
            'search'
        ));
    }

    public function createJadwal()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $dokters = Dokter::with('user')->latest()->get();

        $polis = Poli::latest()->get();

        return view('admin.tambah-jadwal', compact(
            'dokters',
            'polis'
        ));
    }

    public function searchJadwalAjax(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $search = $request->search;

        $jadwals = Jadwal::with(['dokter.user', 'poli'])
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

        $html = view('admin.partials.jadwal-table', compact('jadwals'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }

    public function storeJadwal(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'poli_id' => 'required|exists:polis,id',
            'hari' => 'required|string|max:50',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ], [
            'dokter_id.required' => 'Dokter wajib dipilih.',
            'dokter_id.exists' => 'Dokter tidak valid.',
            'poli_id.required' => 'Poli wajib dipilih.',
            'poli_id.exists' => 'Poli tidak valid.',
            'hari.required' => 'Hari wajib dipilih.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);

        Jadwal::create([
            'dokter_id' => $request->dokter_id,
            'poli_id' => $request->poli_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Data jadwal dokter berhasil ditambahkan!');
    }

    public function editJadwal($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $jadwal = Jadwal::findOrFail($id);

        $dokters = Dokter::with('user')->latest()->get();

        $polis = Poli::latest()->get();

        return view('admin.edit-jadwal', compact(
            'jadwal',
            'dokters',
            'polis'
        ));
    }

    public function updateJadwal(Request $request, $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'poli_id' => 'required|exists:polis,id',
            'hari' => 'required|string|max:50',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ], [
            'dokter_id.required' => 'Dokter wajib dipilih.',
            'dokter_id.exists' => 'Dokter tidak valid.',
            'poli_id.required' => 'Poli wajib dipilih.',
            'poli_id.exists' => 'Poli tidak valid.',
            'hari.required' => 'Hari wajib dipilih.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);

        $jadwal->update([
            'dokter_id' => $request->dokter_id,
            'poli_id' => $request->poli_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Data jadwal dokter berhasil diperbarui!');
    }

    public function destroyJadwal($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->delete();

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Data jadwal dokter berhasil dihapus!');
    }

    public function pendaftaran(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $search = $request->search;

        $pendaftarans = Pendaftaran::with([
            'pasien.user',
            'jadwal.dokter.user',
            'jadwal.poli',
        ])
            ->when($search, function ($query) use ($search) {
                $query->where('nomor_antrean', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereDate('tanggal_daftar', $search)
                    ->orWhereHas('pasien.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jadwal.dokter.user', function ($dokterQuery) use ($search) {
                        $dokterQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jadwal.poli', function ($poliQuery) use ($search) {
                        $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        $totalPendaftaran = Pendaftaran::count();

        $pendaftaranHariIni = Pendaftaran::whereDate('tanggal_daftar', now()->toDateString())->count();

        $pendaftaranSelesai = Pendaftaran::where('status', 'selesai')->count();

        return view('admin.data-pendaftaran', compact(
            'pendaftarans',
            'totalPendaftaran',
            'pendaftaranHariIni',
            'pendaftaranSelesai',
            'search'
        ));
    }

    public function createPendaftaran()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $pasiens = Pasien::with('user')->latest()->get();

        $jadwals = Jadwal::with([
            'dokter.user',
            'poli',
        ])
            ->latest()
            ->get();

        return view('admin.tambah-pendaftaran', compact(
            'pasiens',
            'jadwals'
        ));
    }

    public function searchPendaftaranAjax(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $search = $request->search;

        $pendaftarans = Pendaftaran::with([
                'pasien.user',
                'jadwal.dokter.user',
                'jadwal.poli',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where('nomor_antrian', 'like', '%' . $search . '%')
                    ->orWhere('nomor_antrean', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereDate('tanggal_daftar', $search)
                    ->orWhereHas('pasien.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jadwal.dokter.user', function ($dokterQuery) use ($search) {
                        $dokterQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('jadwal.poli', function ($poliQuery) use ($search) {
                        $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        $html = view('admin.partials.pendaftaran-table', compact('pendaftarans'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }

    public function storePendaftaran(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'jadwal_id' => 'required|exists:jadwals,id',
            'tanggal_daftar' => 'required|date',
            'nomor_antrean' => 'required|integer|min:1',
            'status' => 'required|in:menunggu,diperiksa,selesai,batal',
        ], [
            'pasien_id.required' => 'Pasien wajib dipilih.',
            'pasien_id.exists' => 'Pasien tidak valid.',
            'jadwal_id.required' => 'Jadwal dokter wajib dipilih.',
            'jadwal_id.exists' => 'Jadwal dokter tidak valid.',
            'tanggal_daftar.required' => 'Tanggal daftar wajib diisi.',
            'tanggal_daftar.date' => 'Format tanggal tidak valid.',
            'nomor_antrean.required' => 'Nomor antrean wajib diisi.',
            'nomor_antrean.integer' => 'Nomor antrean harus berupa angka.',
            'nomor_antrean.min' => 'Nomor antrean minimal 1.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        Pendaftaran::create([
            'pasien_id' => $request->pasien_id,
            'jadwal_id' => $request->jadwal_id,
            'tanggal_daftar' => $request->tanggal_daftar,
            'nomor_antrean' => $request->nomor_antrean,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.pendaftaran.index')
            ->with('success', 'Data pendaftaran berhasil ditambahkan!');
    }

    public function editPendaftaran($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $pendaftaran = Pendaftaran::with([
            'pasien.user',
            'jadwal.dokter.user',
            'jadwal.poli',
        ])
            ->findOrFail($id);

        $pasiens = Pasien::with('user')->latest()->get();

        $jadwals = Jadwal::with([
            'dokter.user',
            'poli',
        ])
            ->latest()
            ->get();

        return view('admin.edit-pendaftaran', compact(
            'pendaftaran',
            'pasiens',
            'jadwals'
        ));
    }

    public function updatePendaftaran(Request $request, $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $pendaftaran = Pendaftaran::findOrFail($id);

        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'jadwal_id' => 'required|exists:jadwals,id',
            'tanggal_daftar' => 'required|date',
            'nomor_antrean' => 'required|integer|min:1',
            'status' => 'required|in:menunggu,diperiksa,selesai,batal',
        ], [
            'pasien_id.required' => 'Pasien wajib dipilih.',
            'pasien_id.exists' => 'Pasien tidak valid.',
            'jadwal_id.required' => 'Jadwal dokter wajib dipilih.',
            'jadwal_id.exists' => 'Jadwal dokter tidak valid.',
            'tanggal_daftar.required' => 'Tanggal daftar wajib diisi.',
            'tanggal_daftar.date' => 'Format tanggal tidak valid.',
            'nomor_antrean.required' => 'Nomor antrean wajib diisi.',
            'nomor_antrean.integer' => 'Nomor antrean harus berupa angka.',
            'nomor_antrean.min' => 'Nomor antrean minimal 1.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        $pendaftaran->update([
            'pasien_id' => $request->pasien_id,
            'jadwal_id' => $request->jadwal_id,
            'tanggal_daftar' => $request->tanggal_daftar,
            'nomor_antrean' => $request->nomor_antrean,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.pendaftaran.index')
            ->with('success', 'Data pendaftaran berhasil diperbarui!');
    }

    public function destroyPendaftaran($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $pendaftaran = Pendaftaran::findOrFail($id);

        $pendaftaran->delete();

        return redirect()
            ->route('admin.pendaftaran.index')
            ->with('success', 'Data pendaftaran berhasil dihapus!');
    }

    public function laporanPemeriksaan(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $search = $request->search;

        $pemeriksaans = Pemeriksaan::with([
            'pendaftaran.pasien.user',
            'pendaftaran.jadwal.dokter.user',
            'pendaftaran.jadwal.poli',
        ])
            ->when($search, function ($query) use ($search) {
                $query->where('keluhan', 'like', '%' . $search . '%')
                    ->orWhere('diagnosa', 'like', '%' . $search . '%')
                    ->orWhere('resep', 'like', '%' . $search . '%')
                    ->orWhereHas('pendaftaran.pasien.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('pendaftaran.jadwal.dokter.user', function ($dokterQuery) use ($search) {
                        $dokterQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('pendaftaran.jadwal.poli', function ($poliQuery) use ($search) {
                        $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        $totalPemeriksaan = Pemeriksaan::count();

        $pemeriksaanHariIni = Pemeriksaan::whereDate('created_at', now()->toDateString())->count();

        $totalPasienDiperiksa = Pemeriksaan::whereHas('pendaftaran', function ($query) {
            $query->whereNotNull('pasien_id');
        })
            ->count();

        return view('admin.laporan-pemeriksaan', compact(
            'pemeriksaans',
            'totalPemeriksaan',
            'pemeriksaanHariIni',
            'totalPasienDiperiksa',
            'search'
        ));
    }

    public function searchLaporanAjax(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak.'
            ], 403);
        }

        $search = $request->search;

        $pemeriksaans = Pemeriksaan::with([
                'pendaftaran.pasien.user',
                'pendaftaran.jadwal.dokter.user',
                'pendaftaran.jadwal.poli',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where('keluhan', 'like', '%' . $search . '%')
                    ->orWhere('diagnosa', 'like', '%' . $search . '%')
                    ->orWhere('resep', 'like', '%' . $search . '%')
                    ->orWhereDate('created_at', $search)
                    ->orWhereHas('pendaftaran.pasien.user', function ($pasienQuery) use ($search) {
                        $pasienQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('pendaftaran.jadwal.dokter.user', function ($dokterQuery) use ($search) {
                        $dokterQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('pendaftaran.jadwal.poli', function ($poliQuery) use ($search) {
                        $poliQuery->where('nama_poli', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->get();

        $html = view('admin.partials.laporan-table', compact('pemeriksaans'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }
}
