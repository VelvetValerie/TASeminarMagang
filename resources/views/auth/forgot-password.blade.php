<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Portal BKN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white border-2 border-black p-6 md:p-8 shadow-md">
        <h2 class="text-lg font-black uppercase text-gray-900 border-b-2 border-black pb-2 mb-4">
            Reset Password
        </h2>
        <p class="text-xs text-gray-700 font-medium mb-4 leading-relaxed">
            Masukkan alamat email dinas Anda. Kami akan mengirimkan kode OTP untuk mengatur ulang password.
        </p>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Email Terdaftar</label>
                <input type="email" name="email" placeholder="Contoh: rafifadillah420@gmail.com" required
                       class="w-full border-2 border-black p-2.5 text-sm font-semibold focus:outline-none">
                @error('email')
                    <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full border-2 border-black bg-sky-600 hover:bg-sky-700 text-white font-bold py-2.5 text-sm uppercase transition cursor-pointer">
                Kirim Kode OTP
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-xs font-bold text-gray-700 hover:underline">
                Batal & Kembali Login
            </a>
        </div>
    </div>

</body>
</html>