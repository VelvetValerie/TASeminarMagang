<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('master-user', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'nip'      => 'nullable|string|max:18|unique:users,nip',
            'email'    => 'required|email|max:150|unique:users,email',
            'role'     => 'required|in:pegawai_koordinasi,pegawai_humas,pimpinan', 
            'password' => 'required|min:6',
        ], [
            'username.unique' => 'Username sudah digunakan oleh akun lain.',
            'nip.unique'      => 'NIP sudah terdaftar dalam sistem.',
            'email.unique'    => 'Email sudah digunakan.',
            'role.in'         => 'Role yang dipilih tidak valid atau penambahan akun Admin tidak diizinkan.',
            'password.min'    => 'Password minimal terdiri dari 6 karakter.',
        ]);

        User::create([
            'username' => $request->username,
            'nip'      => $request->nip,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'User baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->withErrors(['admin' => 'Data pengguna dengan Role Admin dilindungi dan tidak dapat diubah.']);
        }

        $request->validate([
            'username' => 'required|string|max:50|unique:users,username,'.$id.',id_user',
            'nip'      => 'nullable|string|max:18|unique:users,nip,'.$id.',id_user',
            'email'    => 'required|email|max:150|unique:users,email,'.$id.',id_user',
            'role'     => 'required|in:pegawai_koordinasi,pegawai_humas,pimpinan',
        ], [
            'role.in' => 'Role yang dipilih tidak valid atau penambahan akun Admin tidak diizinkan.',
        ]);

        $user->username = $request->username;
        $user->nip      = $request->nip;
        $user->email    = $request->email;
        $user->role     = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Data user '.$user->username.' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id_karyawan) {
            $idKaryawan = $user->id_karyawan;

            \App\Models\RekamKj::where('id_karyawan', $idKaryawan)->delete();
            $user->delete();
            \App\Models\Karyawan::where('id_karyawan', $idKaryawan)->delete();
        } else {
            $user->delete();
        }

        return redirect()->back()->with('success', 'User beserta seluruh riwayat rekam kerjanya berhasil dihapus.');
    }
}