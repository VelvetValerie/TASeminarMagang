<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal BKN Kanreg VIII</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white border-2 border-black p-6 md:p-8 shadow-md">
        
        <div class="text-center mb-6">
            <img src="{{ asset('images/Logo_BKN.png') }}" alt="Logo BKN" class="h-12 mx-auto mb-2 object-contain" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/9/9f/Logo_BKN.png';">
            <h2 class="text-xl font-black uppercase text-gray-900">Sistem Kepegawaian</h2>
            <p class="text-xs text-gray-600 font-semibold">Kanreg VIII BKN Banjarmasin</p>
        </div>

        @if(session('success'))
            <div class="mb-4 border-2 border-black bg-emerald-100 p-3 text-xs font-bold text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.perform') }}" class="space-y-4">
            @csrf

            <!-- DUAL INPUT NIP / USERNAME -->
            <div>
                <label class="block text-xs font-bold uppercase mb-1 text-gray-900">NIP / Username</label>
                <input type="text" name="login" value="{{ old('login') }}" placeholder="Masukkan NIP (18 digit) atau Username" required
                       class="w-full border-2 border-black p-2.5 text-sm font-semibold focus:outline-none focus:bg-gray-50 @error('login') border-rose-600 @enderror">
                @error('login')
                    <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- INPUT PASSWORD -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="block text-xs font-bold uppercase text-gray-900">Password</label>
                    <a href="{{ route('password.request') }}" class="text-xs font-bold text-sky-700 hover:underline">
                        Lupa Password?
                    </a>
                </div>
                <input type="password" name="password" placeholder="••••••••" required
                       class="w-full border-2 border-black p-2.5 text-sm font-semibold focus:outline-none focus:bg-gray-50">
            </div>

            <!-- TOMBOL LOGIN -->
            <button type="submit" class="w-full border-2 border-black bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 text-sm uppercase tracking-wider transition cursor-pointer">
                Masuk Sistem
            </button>
        </form>

        <div class="mt-6 text-center border-t-2 border-black pt-4">
            <a href="{{ url('/') }}" class="text-xs font-bold text-gray-700 hover:underline">
                &larr; Kembali ke Landing Page
            </a>
        </div>
    </div>

</body>
</html>