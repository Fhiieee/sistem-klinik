<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pasien;
use App\Models\PasswordResetOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function prosesRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nik' => 'required|unique:pasiens,nik',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

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
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('login')->with('success', 'Register berhasil, silakan login!');
    }

    public function prosesLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $login = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($login) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if (Auth::user()->role == 'dokter') {
                return redirect()->route('dokter.dashboard');
            }

            return redirect()->route('pasien.dashboard');
        }

        return back()->with('error', 'Email atau password salah!')->withInput();
    }

    public function lupaPassword()
    {
        return view('auth.lupa-password');
    }

    public function kirimOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak ditemukan di sistem.',
        ]);

        $otp = rand(100000, 999999);

        PasswordResetOtp::where('email', $request->email)->delete();

        PasswordResetOtp::create([
            'email' => $request->email,
            'otp' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10),
        ]);

        session([
            'reset_email' => $request->email,
        ]);

        Mail::raw(
            "Kode OTP reset password kamu adalah: {$otp}\n\nKode ini berlaku selama 10 menit.\n\nJangan berikan kode ini kepada siapa pun.",
            function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Kode OTP Reset Password - Sistem Informasi Klinik');
            }
        );

        return redirect()
            ->route('password.otp.form')
            ->with('success', 'Kode OTP sudah dikirim ke email kamu.');
    }

    public function formOtp()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request')
                ->with('error', 'Silakan masukkan email terlebih dahulu.');
        }

        return view('auth.verifikasi-otp');
    }

    public function verifikasiOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus 6 digit.',
        ]);

        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi reset password habis. Silakan ulangi lagi.');
        }

        $dataOtp = PasswordResetOtp::where('email', $email)->latest()->first();

        if (!$dataOtp) {
            return back()->with('error', 'Kode OTP tidak ditemukan. Silakan kirim ulang kode.');
        }

        if (now()->greaterThan($dataOtp->expires_at)) {
            $dataOtp->delete();

            return redirect()->route('password.request')
                ->with('error', 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang.');
        }

        if (!Hash::check($request->otp, $dataOtp->otp)) {
            return back()->with('error', 'Kode OTP salah.');
        }

        $dataOtp->update([
            'verified_at' => now(),
        ]);

        session([
            'reset_verified_email' => $email,
        ]);

        return redirect()->route('password.otp.reset.form')
            ->with('success', 'Kode OTP benar. Silakan buat password baru.');
    }

    public function formResetOtp()
    {
        if (!session('reset_verified_email')) {
            return redirect()->route('password.request')
                ->with('error', 'Silakan verifikasi OTP terlebih dahulu.');
        }

        return view('auth.reset-password', [
            'email' => session('reset_verified_email'),
        ]);
    }

    public function prosesResetOtp(Request $request)
    {
        $email = session('reset_verified_email');

        if (!$email) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi reset password habis. Silakan ulangi lagi.');
        }

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->with('error', 'User tidak ditemukan.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        PasswordResetOtp::where('email', $email)->delete();

        session()->forget([
            'reset_email',
            'reset_verified_email',
        ]);

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
