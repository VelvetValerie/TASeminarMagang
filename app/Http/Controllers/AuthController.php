<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required'    => 'NIP atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $fieldType = is_numeric($request->login) ? 'nip' : 'username';

        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login' => 'NIP/Username atau Password yang Anda masukkan salah.',
        ])->onlyInput('login');
    }

    // 3. Tampilkan Form Lupa Password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // 4. Kirim Reset OTP
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Alamat email tidak terdaftar dalam sistem kepegawaian.',
        ]);

        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token'      => Hash::make($otpCode),
                'created_at' => Carbon::now()
            ]
        );

        session([
            'reset_email' => $request->email,
            'demo_otp'    => $otpCode
        ]);

        return redirect()->route('password.verify.form')
            ->with('success', 'Kode konfirmasi OTP telah dikirimkan ke email Anda.');
    }

    // 5. Tampilkan Form Verifikasi OTP (METHOD YANG HILANG)
    public function showVerifyOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-otp');
    }

    // 6. Proses Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp'                   => 'required|numeric',
            'password'              => 'required|min:6|confirmed',
        ], [
            'otp.required'          => 'Kode OTP wajib diisi.',
            'password.confirmed'    => 'Konfirmasi password baru tidak cocok.',
            'password.min'          => 'Password minimal 6 karakter.'
        ]);

        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi reset password telah berakhir. Silakan minta OTP baru.']);
        }

        $resetData = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$resetData) {
            return back()->withErrors(['otp' => 'Kode OTP tidak ditemukan atau telah kadaluwarsa.']);
        }

        $isExpired = Carbon::parse($resetData->created_at)->addMinutes(10)->isPast();
        if ($isExpired) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluwarsa (lebih dari 10 menit). Silakan minta OTP baru.']);
        }

        if (!Hash::check($request->otp, $resetData->token)) {
            return back()->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah.']);
        }

        $user = User::where('email', $email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            DB::table('password_reset_tokens')->where('email', $email)->delete();
            session()->forget(['reset_email', 'demo_otp']);

            return redirect()->route('login')->with('success', 'Password berhasil diperbarui! Silakan login kembali.');
        }

        return back()->withErrors(['email' => 'Terjadi kesalahan sistem.']);
    }

    // 7. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}