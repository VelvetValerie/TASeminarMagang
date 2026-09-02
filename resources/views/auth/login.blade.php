<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Sistem - BKN Kanreg VIII</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 sm:p-6 bg-slate-100 antialiased">

    <div class="w-full max-w-md">
        <!-- Kartu Login Border 2px -->
        <div class="bg-white border-2 border-black rounded-2xl p-6 sm:p-8 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
            
            <!-- Header Kartu: Logo BKN & Judul Instansi -->
            <div class="flex flex-col items-center text-center pb-6 border-b-2 border-black">
                <div class="w-16 h-16 bg-white border-2 border-black rounded-2xl flex items-center justify-center p-2 mb-3 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                    <img src="{{ asset('images/Logo_BKN.png') }}" 
                         onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/9/9f/Logo_BKN.png';" 
                         alt="Logo BKN" 
                         class="h-full w-auto object-contain">
                </div>
                <h1 class="text-xl font-extrabold text-gray-900 tracking-tight">BKN KANREG VIII</h1>
                <p class="text-xs font-semibold text-sky-700 tracking-wide uppercase mt-0.5">Sistem Perencanaan & Manajemen Kegiatan</p>
            </div>

            <!-- Notifikasi Error Validasi -->
            @if ($errors->any())
                <div class="mt-4 p-3 border-2 border-black bg-rose-100 text-rose-900 text-xs font-semibold rounded-lg">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulir Login Berbasis Username -->
            <form method="POST" action="{{ route('login.perform') }}" class="mt-6 space-y-4">
                @csrf

                <!-- Username Input -->
                <div class="space-y-1">
                    <label for="username" class="block text-xs font-bold text-gray-900 uppercase tracking-wider">
                        Username
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="username" 
                               name="username" 
                               value="{{ old('username') }}" 
                               required 
                               autofocus 
                               autocomplete="username"
                               placeholder="Masukkan username akun Anda"
                               class="w-full border-2 border-black px-3.5 py-2 text-sm text-gray-900 font-medium rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-1">
                    <label for="password" class="block text-xs font-bold text-gray-900 uppercase tracking-wider">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full border-2 border-black px-3.5 py-2 text-sm text-gray-900 font-medium rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                    </div>
                </div>

                <!-- Ingat Saya Checkbox -->
                <div class="flex items-center pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer text-xs font-semibold text-gray-700 select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-2 border-black accent-sky-600">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full border-2 border-black bg-sky-600 hover:bg-sky-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] transition cursor-pointer">
                        Masuk ke Akun
                    </button>
                </div>
            </form>
            </div>

        </div>
    </div>

</body>
</html>