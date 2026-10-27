<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login (Dukungan NIP, Username, dan Email)
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required'    => 'NIP / Username / Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $input = trim($request->input('login'));
        $password = $request->input('password');

        // Tentukan kolom database yang dicari (NIP / Email / Username)
        if (numeric_only($input) && strlen($input) === 18) {
            $fieldType = 'nip';
        } elseif (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $fieldType = 'email';
        } else {
            $fieldType = 'username';
        }

        $credentials = [
            $fieldType => $input,
            'password'  => $password,
        ];

        // Jalankan Autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Buat throttle key berdasarkan input login dan IP user
        $throttleKey = strtolower($request->input('login')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'login' => "Terlalu banyak percobaan login yang gagal. Silakan coba lagi dalam {$seconds} detik.",
            ])->onlyInput('login');
        }

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey); // Reset percobaan jika berhasil
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

    // Catat kegagalan login
    RateLimiter::hit($throttleKey, 60);

        // Jika Percobaan Pertama Gagal, Coba Cek sebagai Username (Fallback)
        if ($fieldType !== 'username') {
            if (Auth::attempt(['username' => $input, 'password' => $password])) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'login' => 'NIP/Username/Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('login');
    }

    // 3. Tampilkan Form Lupa Password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // 4. Kirim Reset OTP via Email
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.exists'   => 'Alamat email tidak terdaftar dalam sistem kepegawaian.',
        ]);

        $existingToken = DB::table('password_reset_tokens')
                       ->where('email', $request->email)
                       ->first();

        // Batasi pengiriman ulang minimal jeda 60 detik
        if ($existingToken && Carbon::parse($existingToken->created_at)->addSeconds(60)->isFuture()) {
            $remainingSeconds = Carbon::now()->diffInSeconds(Carbon::parse($existingToken->created_at)->addSeconds(60));
            return back()->withErrors([
                'email' => "Kode OTP baru saja dikirimkan. Harap tunggu {$remainingSeconds} detik sebelum meminta kode baru."
            ]);
        }

        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan hash kode OTP ke database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token'      => Hash::make($otpCode),
                'created_at' => Carbon::now()
            ]
        );

        // Cari data pengguna untuk sapaan email
        $user = User::where('email', $request->email)->first();
        $userName = $user ? ($user->name ?? $user->username ?? 'Pengguna') : 'Pengguna';

        // PROSES PENGIRIMAN EMAIL SUNGGUHAN
        try {
            Mail::send([], [], function ($message) use ($request, $otpCode, $userName) {
                $message->to($request->email)
                    ->subject('Kode OTP Reset Password - Kanreg VIII BKN')
                    ->html("
                        <div style='font-family: Arial, sans-serif; padding: 20px; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; rounded: 8px;'>
                            <h2 style='color: #1e293b; border-bottom: 2px solid #0f172a; pb-2;'>Permintaan Reset Password</h2>
                            <p>Halo <strong>{$userName}</strong>,</p>
                            <p>Kami menerima permintaan untuk meriset kata sandi akun Anda pada Sistem Informasi Administrasi Kegiatan Kanreg VIII BKN.</p>
                            <p>Gunakan kode OTP di bawah ini untuk melanjutkan proses verifikasi:</p>
                            
                            <div style='text-align: center; margin: 25px 0;'>
                                <span style='display: inline-block; font-size: 32px; font-weight: bold; letter-spacing: 6px; background-color: #f1f5f9; padding: 12px 24px; border: 2px dashed #0284c7; color: #0369a1;'>{$otpCode}</span>
                            </div>

                            <p style='font-size: 13px; color: #64748b;'>* Kode OTP ini berlaku selama <strong>10 menit</strong>. Jangan bagikan kode ini kepada siapa pun demi keamanan akun Anda.</p>
                            <hr style='border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;' />
                            <p style='font-size: 11px; color: #94a3b8; text-align: center;'>Email ini dikirimkan secara otomatis oleh sistem, mohon tidak membalas email ini.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            // Jika terjadi kesalahan pengiriman email (misal koneksi SMTP terputus)
            return back()->withErrors(['email' => 'Gagal mengirimkan email OTP. Silakan periksa koneksi atau konfigurasi SMTP server Anda. Error: ' . $e->getMessage()]);
        }

        session([
            'reset_email' => $request->email,
        ]);

        return redirect()->route('password.verify.form')
            ->with('success', 'Kode OTP telah berhasil dikirimkan ke email ' . $request->email);
    }

    // 5. Tampilkan Form Verifikasi OTP
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
            'otp.required'       => 'Kode OTP wajib diisi.',
            'password.required'  => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min'       => 'Password minimal 6 karakter.'
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
            session()->forget('reset_email');

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

/**
 * Helper Sederhana Pengecekan Angka (Mencegah Error jika Ctype Belum Aktif)
 */
if (!function_exists('numeric_only')) {
    function numeric_only($string) {
        return preg_match('/^[0-9]+$/', $string);
    }
}