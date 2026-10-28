@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- HEADER PAGE -->
    <div class="border-2 border-black bg-white p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h1 class="text-xl font-extrabold text-gray-900 uppercase">Pengaturan Profil Saya</h1>
        <p class="text-xs text-gray-600 font-medium">Kelola informasi data diri dan kata sandi akun Anda.</p>
    </div>

    <!-- FORM DATA DIRI & FOTO -->
    <div class="border-2 border-black bg-white p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h2 class="text-base font-bold text-gray-900 pb-3 border-b-2 border-black mb-5">Informasi Akun</h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Foto Profil Preview & Upload -->
            <div class="flex flex-col sm:flex-row items-center gap-4 pb-4 border-b border-gray-200">
                <div class="w-20 h-20 border-2 border-black rounded-full overflow-hidden bg-slate-200 shrink-0 flex items-center justify-center">
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="w-full h-full object-cover">
                    @else
                        <span class="text-2xl font-bold text-gray-600 uppercase">
                            {{ substr($user->name ?? $user->username ?? 'U', 0, 2) }}
                        </span>
                    @endif
                </div>
                <div class="space-y-1 text-center sm:text-left">
                    <label class="block text-xs font-bold text-gray-900 uppercase">Unggah Foto Baru</label>
                    <input type="file" name="foto" class="text-xs text-gray-700 file:mr-3 file:py-1.5 file:px-3 file:border-2 file:border-black file:text-xs file:font-bold file:bg-amber-400 hover:file:bg-amber-500 file:cursor-pointer">
                    <p class="text-[11px] text-gray-500">* Format JPG, PNG, WEBP. Maksimal 2MB.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase mb-1">Nama Lengkap</label>
                    @if($user->role === 'admin')
                        <input type="text" name="name" value="{{ old('name', $user->name ?? $user->username) }}" class="w-full border-2 border-black p-2 text-sm font-semibold focus:outline-none focus:bg-amber-50">
                    @else
                        <input type="text" value="{{ $user->name ?? $user->username }}" disabled class="w-full border-2 border-gray-300 bg-gray-100 p-2 text-sm font-semibold text-gray-500 cursor-not-allowed" title="Nama akun hanya dapat diubah oleh Administrator">
                        <span class="text-[10px] text-amber-700 font-semibold">* Nama akun terkunci (Hubungi Admin untuk perubahan nama).</span>
                    @endif
                </div>

                <!-- Username (Readonly untuk semua) -->
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase mb-1">Username / NIP</label>
                    <input type="text" value="{{ $user->username ?? $user->nip ?? '-' }}" disabled class="w-full border-2 border-gray-300 bg-gray-100 p-2 text-sm font-semibold text-gray-500 cursor-not-allowed">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase mb-1">Role / Hak Akses</label>
                    <input type="text" value="{{ strtoupper($user->role) }}" disabled class="w-full border-2 border-gray-300 bg-gray-100 p-2 text-sm font-semibold text-gray-500 cursor-not-allowed">
                </div>

                <!-- Email (Bisa diubah semua role) -->
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border-2 border-black p-2 text-sm font-semibold focus:outline-none focus:bg-amber-50">
                </div>
            </div>

            <div class="pt-3">
                <button type="submit" class="border-2 border-black bg-amber-400 hover:bg-amber-500 text-black font-extrabold px-5 py-2 text-xs uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition">
                    💾 Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- FORM GANTI PASSWORD -->
    <div class="border-2 border-black bg-white p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h2 class="text-base font-bold text-gray-900 pb-3 border-b-2 border-black mb-5">Pembaruan Kata Sandi</h2>

        <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" required class="w-full border-2 border-black p-2 text-sm font-semibold focus:outline-none focus:bg-amber-50">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase mb-1">Password Baru</label>
                    <input type="password" name="password" required class="w-full border-2 border-black p-2 text-sm font-semibold focus:outline-none focus:bg-amber-50">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full border-2 border-black p-2 text-sm font-semibold focus:outline-none focus:bg-amber-50">
                </div>
            </div>

            <div class="pt-3">
                <button type="submit" class="border-2 border-black bg-rose-500 hover:bg-rose-600 text-white font-extrabold px-5 py-2 text-xs uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition">
                    🔑 Perbarui Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection