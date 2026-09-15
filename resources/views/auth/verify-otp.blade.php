<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Portal BKN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white border-2 border-black p-6 md:p-8 shadow-md">
        <h2 class="text-lg font-black uppercase text-gray-900 border-b-2 border-black pb-2 mb-2">
            Konfirmasi Kode OTP
        </h2>
        
        <!-- NOTIFIKASI OTP ACAK DINAMIS -->
        <div class="mb-4 bg-amber-50 border-2 border-black p-3 text-xs font-bold text-amber-900">
            <strong>[Demo Presentasi]:</strong> Kode OTP dikirimkan ke <u>{{ session('reset_email') }}</u> (Kode OTP terisi otomatis: <strong>{{ session('reset_otp') }}</strong>).
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf

            <!-- INPUT OTP (AUTO-FILL NILAI ACAK DARI SESSION) -->
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Kode Konfirmasi OTP</label>
                <input type="text" name="otp" value="{{ session('reset_otp') }}" required readonly
                       class="w-full border-2 border-black p-2.5 text-sm font-bold bg-gray-100 text-center tracking-widest text-lg">
                @error('otp')
                    <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase mb-1">Password Baru</label>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required
                       class="w-full border-2 border-black p-2.5 text-sm font-semibold focus:outline-none">
                @error('password')
                    <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase mb-1">Ulangi Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Sama dengan password baru" required
                       class="w-full border-2 border-black p-2.5 text-sm font-semibold focus:outline-none">
            </div>

            <button type="submit" class="w-full border-2 border-black bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 text-sm uppercase transition cursor-pointer">
                Simpan Password Baru
            </button>
        </form>
    </div>

</body>
</html>