<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Kanreg VIII BKN</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Logo_BKN.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white border-4 border-black p-6 sm:p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] text-center">
        <!-- Badge Angka Error -->
        <div class="inline-block bg-sky-500 text-white border-2 border-black px-4 py-1 font-extrabold text-2xl tracking-widest shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] mb-4">
            404 ERROR
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-2 uppercase">
            Halaman Hilang!
        </h1>

        <p class="text-sm font-semibold text-gray-700 mb-6 leading-relaxed">
            Halaman yang Anda cari tidak ditemukan atau alamat URL yang dimasukkan salah.
        </p>

        <!-- Ilustrasi/Icon Sederhana -->
        <div class="bg-sky-100 border-2 border-black p-4 mb-6 flex items-center justify-center">
            <span class="text-4xl">🔍</span>
        </div>

        <!-- Tombol Kembali -->
        <a href="{{ url('/dashboard') }}" 
           class="block w-full border-2 border-black bg-sky-400 hover:bg-sky-500 text-black font-extrabold py-3 px-4 uppercase tracking-wider text-sm shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-0.5 hover:translate-y-0.5 transition active:shadow-none">
            🏠 Kembali ke Halaman Utama
        </a>
    </div>

</body>
</html>