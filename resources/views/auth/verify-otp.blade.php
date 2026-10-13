<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Kode OTP - Kantor Regional BKN</title>
    
    <!-- FAVICON LOGO BKN -->
    <link rel="icon" type="image/png" href="{{ asset('images/Logo_BKN.png') }}?v=1">
    
    <!-- Google Fonts & Tailwind CSS CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white border-2 border-black p-6 sm:p-8 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
        
        <!-- Judul Halaman -->
        <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight uppercase mb-4 pb-2 border-b-2 border-black">
            Konfirmasi Kode OTP
        </h2>

        <!-- Notifikasi Pesan Sukses / Error -->
        @if (session('success'))
            <div class="mb-4 border-2 border-black bg-emerald-100 p-3 text-xs font-bold text-emerald-950">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 border-2 border-black bg-rose-100 p-3 text-xs font-bold text-rose-950">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <!-- Alert Banner Demo Presentasi -->
        <div class="mb-5 p-3 bg-amber-50 border-2 border-black text-amber-950 text-xs font-medium">
            <span class="font-bold">[Demo Presentasi]:</span> Kode OTP dikirimkan ke 
            <span class="font-extrabold underline">{{ session('reset_email') ?? 'email' }}</span> 
            (Kode OTP terisi otomatis: <span class="font-extrabold text-amber-900">{{ session('demo_otp') ?? '-' }}</span>).
        </div>

        <!-- Form Reset Password & Verifikasi OTP -->
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf

            <!-- Input Kode OTP -->
            <div>
                <label for="otp" class="block text-xs font-bold uppercase text-gray-900 mb-1">
                    Kode Konfirmasi OTP
                </label>
                <input type="text" 
                       id="otp" 
                       name="otp" 
                       value="{{ old('otp', session('demo_otp')) }}" 
                       required 
                       placeholder="Masukkan 6 Digit OTP"
                       class="w-full p-2.5 border-2 border-black bg-slate-100 font-mono font-extrabold text-center tracking-widest text-lg text-gray-900 focus:outline-none focus:bg-white transition">
                @error('otp')
                    <p class="text-rose-600 text-xs mt-1 font-bold">⚠️ {{ $message }}</p>
                @enderror
            </div>

            <!-- Input Password Baru -->
            <div>
                <label for="password" class="block text-xs font-bold uppercase text-gray-900 mb-1">
                    Password Baru
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Minimal 6 karakter" 
                       required 
                       class="w-full p-2.5 border-2 border-black bg-white font-medium text-sm text-gray-900 focus:outline-none">
                @error('password')
                    <p class="text-rose-600 text-xs mt-1 font-bold">⚠️ {{ $message }}</p>
                @enderror
            </div>

            <!-- Input Ulangi Password Baru -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase text-gray-900 mb-1">
                    Ulangi Password Baru
                </label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       placeholder="Sama dengan password baru" 
                       required 
                       class="w-full p-2.5 border-2 border-black bg-white font-medium text-sm text-gray-900 focus:outline-none">
            </div>

            <!-- Tombol Submit -->
            <div class="pt-2">
                <button type="submit" class="w-full py-3 bg-emerald-700 hover:bg-emerald-800 border-2 border-black text-white font-extrabold text-xs uppercase tracking-wider transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] active:translate-x-0.5 active:translate-y-0.5 cursor-pointer">
                    Simpan Password Baru
                </button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-xs font-bold text-gray-600 hover:text-black underline">
                &laquo; Kembali ke Halaman Login
            </a>
        </div>

    </div>

</body>
</html>