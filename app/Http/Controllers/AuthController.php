<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

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

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Alamat email tidak terdaftar dalam sistem kepegawaian.',
        ]);

        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        session([
            'reset_email' => $request->email,
            'reset_otp'   => $otpCode
        ]);

        return redirect()->route('password.verify.form')->with('success', 'Kode konfirmasi OTP telah dikirimkan ke email Anda.');
    }

    public function showVerifyOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-otp');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp'                   => 'required',
            'password'              => 'required|min:6|confirmed',
        ], [
            'password.confirmed'    => 'Konfirmasi password baru tidak cocok.',
            'password.min'          => 'Password minimal terdiri dari 6 karakter.'
        ]);

        if ($request->otp != session('reset_otp')) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        $user = User::where('email', session('reset_email'))->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            session()->forget(['reset_email', 'reset_otp']);

            return redirect()->route('login')->with('success', 'Password berhasil diperbarui! Silakan login kembali.');
        }

        return back()->withErrors(['email' => 'Terjadi kesalahan sistem.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}