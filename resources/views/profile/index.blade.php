@extends('layouts.app')

<title>Kantor Regional BKN - Pengaturan Profil</title>

@section('navbar-left')
    <div class="border-2 border-black bg-white px-6 py-1.5 font-bold text-gray-900">
        Pengaturan Profil
    </div>
@endsection

@section('navbar-right')
    <div class="border-2 border-black bg-white px-8 py-1.5 font-semibold text-gray-900">
        {{ Auth::user()->username ?? 'Username' }}
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- CARD INFORMASI PENGGUNAKAN & EDIT PROFIL -->
    <div class="border-2 border-black bg-white p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <h2 class="text-base sm:text-lg font-extrabold text-gray-900 uppercase tracking-wider pb-3 border-b-2 border-black mb-5 flex items-center justify-between">
            <span>👤 Informasi Profil Pengguna</span>
            <span class="text-xs bg-amber-300 border-2 border-black px-2.5 py-1 font-extrabold uppercase shadow-xs">
                Peran: {{ str_replace('_', ' ', strtoupper($user->role)) }}
            </span>
        </h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Preview & Upload Foto Profil -->
            <div class="flex flex-col sm:flex-row items-center gap-5 pb-5 border-b-2 border-black">
                <div class="w-20 h-20 border-2 border-black rounded-full overflow-hidden bg-slate-200 shrink-0 flex items-center justify-center shadow-xs">
                    @if($user->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto))
                        <img src="{{ asset('storage/' . $user->foto) }}" 
                             alt="Foto Profil" 
                             class="w-full h-full object-cover">
                    @else
                        <span class="text-2xl font-extrabold text-gray-700 uppercase">
                            {{ substr($user->username ?? 'U', 0, 2) }}
                        </span>
                    @endif
                </div>

                <div class="space-y-1 text-center sm:text-left">
                    <label class="block text-xs font-extrabold text-gray-900 uppercase">Unggah Foto Profil Baru</label>
                    <input type="file" name="foto" class="text-xs text-gray-700 file:mr-3 file:py-1.5 file:px-3 file:border-2 file:border-black file:text-xs file:font-bold file:bg-amber-400 hover:file:bg-amber-500 file:cursor-pointer">
                    <p class="text-[11px] text-gray-500 font-medium">* Format JPG, PNG, WEBP. Maksimal 2MB.</p>
                </div>
            </div>

            <!-- GRID FIELD INFORMASI PENGGUNAKAN -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <!-- NIP (Nomor Induk Pegawai) -->
                <div>
                    <label class="block text-xs font-extrabold text-gray-900 uppercase mb-1">
                        NIP (Nomor Induk Pegawai)
                        <span class="text-gray-500 text-[10px] lowercase font-normal">(terkunci)</span>
                    </label>
                    <input type="text" 
                           value="{{ $user->nip ?? '-' }}" 
                           readonly
                           class="w-full border-2 border-black bg-gray-100 px-3 py-2 text-sm font-bold text-gray-700 cursor-not-allowed select-none">
                </div>

                <!-- Peran / Role Akun -->
                <div>
                    <label class="block text-xs font-extrabold text-gray-900 uppercase mb-1">
                        Hak Akses / Peran
                        <span class="text-gray-500 text-[10px] lowercase font-normal">(terkunci)</span>
                    </label>
                    <input type="text" 
                           value="{{ strtoupper(str_replace('_', ' ', $user->role)) }}" 
                           readonly
                           class="w-full border-2 border-black bg-gray-100 px-3 py-2 text-sm font-bold text-gray-700 cursor-not-allowed select-none">
                </div>

            </div>

            <!-- Nama User / Username -->
            <div>
                <label class="block text-xs font-extrabold text-gray-900 uppercase mb-1">
                    Nama Pengguna / Username 
                    @if($user->role !== 'admin')
                        <span class="text-rose-600 text-[10px] lowercase font-normal">(dikunci oleh sistem)</span>
                    @endif
                </label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $user->username) }}" 
                       {{ $user->role !== 'admin' ? 'readonly' : '' }}
                       class="w-full border-2 border-black px-3 py-2 text-sm font-semibold {{ $user->role !== 'admin' ? 'bg-gray-100 cursor-not-allowed text-gray-600' : 'bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-black' }}">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs font-extrabold text-gray-900 uppercase mb-1">Alamat Email (Untuk Pengiriman OTP)</label>
                <input type="email" 
                       name="email" 
                       value="{{ old('email', $user->email) }}" 
                       required
                       class="w-full border-2 border-black bg-white px-3 py-2 text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-black">
                @error('email')
                    <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Simpan -->
            <div class="pt-3 flex justify-end">
                <button type="submit" class="border-2 border-black bg-amber-400 hover:bg-amber-500 font-bold px-6 py-2 text-xs uppercase tracking-wider text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition cursor-pointer">
                    💾 Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>

</div>
@endsection