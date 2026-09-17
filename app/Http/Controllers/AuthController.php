<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    // Menampilkan halaman formulir login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // Memproses autentikasi berbasis username
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Autentikasi dengan username dan password (ditambah percabangan if)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Jika berhasil, arahkan ke dashboard
            return redirect()->intended(route('dashboard'));
        }

        // Jika gagal autentikasi, kembalikan ke form login dengan error
        return back()->withErrors([
            'username' => 'Username atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    // Logout dan kembalikan ke landing page
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Mengarahkan kembali ke landing page (route 'landing' atau path '/')
        return redirect()->route('landing');
    }

    // Menghapus fungsi destroy() duplikat agar metode logout terpusat di logout()
}