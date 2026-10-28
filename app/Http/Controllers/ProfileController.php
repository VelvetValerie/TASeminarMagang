<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan Halaman Pengaturan Profil
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Proses Update Data Profil (Username/Email & Foto)
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Ambil nama primary key dan nilainya secara dinamis (misal: 'id_user' atau 'id_karyawan')
        $primaryKeyName  = $user->getKeyName();
        $primaryKeyValue = $user->getKey();

        // Validasi Dasar
        $rules = [
            'email' => "required|email|max:255|unique:users,email,{$primaryKeyValue},{$primaryKeyName}",
            'foto'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];

        // Validasi penamaan hanya dibuka untuk Admin
        if ($user->role === 'admin') {
            $rules['name'] = 'required|string|max:255';
        }

        $request->validate($rules, [
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique'   => 'Alamat email sudah digunakan oleh user lain.',
            'foto.image'     => 'File harus berupa gambar.',
            'foto.max'       => 'Ukuran foto maksimal 2MB.',
        ]);

        // Simpan ke kolom 'username' jika role adalah Admin (mencegah error column 'name' not found)
        if ($user->role === 'admin' && $request->has('name')) {
            $user->username = $request->input('name');
        }

        $user->email = $request->input('email');

        // Proses Unggah Foto Profil
        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->foto = $request->file('foto')->store('profile_photos', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Proses Pembaruan Kata Sandi / Password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.confirmed'        => 'Konfirmasi password baru tidak cocok.',
            'password.min'              => 'Password minimal 6 karakter.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}