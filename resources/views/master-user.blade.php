@extends('layouts.app')

<title>Kantor Regional BKN - Manajemen User</title>

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl space-y-6">

    <!-- HEADER LAMAN -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b-2 border-black pb-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 uppercase tracking-tight">
                Manajemen Data User
            </h1>
            <p class="text-xs sm:text-sm font-semibold text-gray-600">
                Kelola hak akses pengguna, NIP, email, dan peranan sistem kepegawaian BKN
            </p>
        </div>
        
        <button type="button" onclick="openAddUserModal()" 
                class="border-2 border-black bg-slate-900 hover:bg-slate-800 text-white font-bold px-4 py-2 text-xs sm:text-sm uppercase tracking-wider transition cursor-pointer shadow-xs self-start md:self-auto">
            + Tambah User Baru
        </button>
    </div>

    <!-- NOTIFIKASI SUKSES / ERROR -->
    @if(session('success'))
        <div class="border-2 border-black bg-emerald-100 p-3 text-xs font-bold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="border-2 border-black bg-rose-100 p-3 text-xs font-bold text-rose-800 space-y-1">
            @foreach($errors->all() as $err)
                <p>• {{ $err }}</p>
            @endforeach
        </div>
    @endif

    <!-- KOTAK UTAMA -->
    <div class="border-2 border-black bg-white p-4 md:p-6 relative shadow-sm space-y-4">

        <!-- KONTROL PENCARIAN & FILTER ROLE -->
        <div class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b-2 border-black">
            <div class="w-full sm:w-72">
                <input type="text" id="userSearchInput" placeholder="Cari NIP, Nama, atau Username..." 
                       class="w-full border-2 border-black px-3 py-1.5 text-xs sm:text-sm font-semibold focus:outline-none bg-gray-50 focus:bg-white">
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase text-gray-700">Filter Role:</span>
                <select id="roleFilterSelect" class="border-2 border-black px-3 py-1.5 text-xs sm:text-sm font-bold bg-white focus:outline-none">
                    <option value="all">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="pimpinan">Pimpinan</option>
                    <option value="pegawai">Pegawai</option>
                </select>
            </div>
        </div>

        <!-- TABEL DATA USER -->
        <div class="border-2 border-black overflow-x-auto">
            <table class="w-full border-collapse border-black min-w-[700px] text-left">
                <thead>
                    <tr class="border-b-2 border-black bg-gray-100 font-bold text-xs uppercase tracking-wider text-gray-900">
                        <th class="border-r-2 border-black p-3 text-center w-12">No</th>
                        <th class="border-r-2 border-black p-3">NIP & Username</th>
                        <th class="border-r-2 border-black p-3">Email Dinas</th>
                        <th class="border-r-2 border-black p-3 text-center w-36">Role Access</th>
                        <th class="p-3 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-xs sm:text-sm font-semibold divide-y-2 divide-black">
                    @forelse ($users as $index => $u)
                        <tr class="user-row border-b-2 border-black hover:bg-gray-50 transition" data-role="{{ strtolower($u->role) }}">
                            <td class="border-r-2 border-black p-3 text-center font-bold text-gray-600">
                                {{ $index + 1 }}
                            </td>
                            <td class="border-r-2 border-black p-3">
                                <div class="font-black text-gray-900">{{ $u->username }}</div>
                                <div class="text-xs font-mono text-gray-600">NIP: {{ $u->nip ?? '-' }}</div>
                            </td>
                            <td class="border-r-2 border-black p-3 font-medium text-gray-800">
                                {{ $u->email ?? '-' }}
                            </td>
                            <td class="border-r-2 border-black p-3 text-center">
                                @if($u->role === 'admin')
                                    <span class="inline-block border-2 border-black bg-rose-200 text-rose-900 px-2.5 py-0.5 text-[11px] font-black uppercase rounded-full">
                                        Admin
                                    </span>
                                @elseif($u->role === 'pimpinan')
                                    <span class="inline-block border-2 border-black bg-amber-200 text-amber-900 px-2.5 py-0.5 text-[11px] font-black uppercase rounded-full">
                                        Pimpinan
                                    </span>
                                @else
                                    <span class="inline-block border-2 border-black bg-sky-200 text-sky-900 px-2.5 py-0.5 text-[11px] font-black uppercase rounded-full">
                                        Pegawai
                                    </span>
                                @endif
                            </td>
                            <td class="p-3 text-center">
                                @if($u->role === 'admin')
                                    <!-- JIKA ROLE ADMIN: TOMBOL TERKUNCI / DISABLED -->
                                    <span class="text-[11px] font-bold text-gray-400 italic bg-gray-100 border border-gray-300 px-2 py-1 rounded">
                                        Protected
                                    </span>
                                @else
                                    <!-- JIKA PEGAWAI / PIMPINAN: TOMBOL EDIT DAN HAPUS AKTIF -->
                                    <div class="flex items-center justify-center gap-1">
                                        <button type="button" title="Edit Data User"
                                                onclick="openEditUserModal('{{ $u->id_user }}', '{{ $u->username }}', '{{ $u->nip }}', '{{ $u->email }}', '{{ $u->role }}')" 
                                                class="border-2 border-black bg-gray-200 hover:bg-gray-300 p-1.5 font-bold transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button type="button" title="Hapus User" 
                                                onclick="openDeleteUserModal('{{ $u->id_user }}', '{{ $u->username }}')"
                                                class="border-2 border-black bg-rose-500 hover:bg-rose-600 text-white p-1.5 font-bold transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500 font-bold">
                                Belum ada data pengguna terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- ================= MODAL EDIT USER ================= -->
<div id="editUserModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
    <div class="relative w-full max-w-lg bg-white border-2 border-black p-6 shadow-2xl space-y-4">
        <div class="flex items-center justify-between border-b-2 border-black pb-3">
            <h3 class="text-base sm:text-lg font-black uppercase text-gray-900">
                Edit Data User
            </h3>
            <button type="button" onclick="closeEditUserModal()" class="text-rose-600 hover:text-rose-800 font-bold text-xl cursor-pointer">&times;</button>
        </div>

        <form id="editUserForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold uppercase mb-1">Username</label>
                <input type="text" id="edit_username" name="username" required 
                       class="w-full border-2 border-black p-2 text-xs sm:text-sm font-semibold focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase mb-1">NIP (Nomor Induk Pegawai)</label>
                <input type="text" id="edit_nip" name="nip" maxlength="18" placeholder="18 digit NIP"
                       class="w-full border-2 border-black p-2 text-xs sm:text-sm font-semibold focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase mb-1">Email Dinas</label>
                <input type="email" id="edit_email" name="email" required 
                       class="w-full border-2 border-black p-2 text-xs sm:text-sm font-semibold focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase mb-1">Role Access</label>
                <select id="edit_role" name="role" required class="w-full border-2 border-black p-2 text-xs sm:text-sm font-bold bg-white focus:outline-none">
                    <option value="pegawai">Pegawai</option>
                    <option value="pimpinan">Pimpinan</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase mb-1">Password Baru <span class="text-gray-500 font-normal">(Kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" placeholder="••••••••" 
                       class="w-full border-2 border-black p-2 text-xs sm:text-sm font-semibold focus:outline-none">
            </div>

            <div class="flex justify-end gap-2 border-t-2 border-black pt-4">
                <button type="button" onclick="closeEditUserModal()" 
                        class="border-2 border-black bg-gray-200 hover:bg-gray-300 font-bold px-4 py-1.5 text-xs uppercase cursor-pointer">
                    Batal
                </button>
                <button type="submit" 
                        class="border-2 border-black bg-slate-900 hover:bg-slate-800 text-white font-bold px-4 py-1.5 text-xs uppercase cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL HAPUS USER ================= -->
<div id="deleteUserModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
    <div class="relative w-full max-w-md bg-white border-2 border-black p-6 shadow-2xl space-y-4">
        <div class="border-b-2 border-black pb-2">
            <h3 class="text-base sm:text-lg font-black uppercase text-rose-600">
                Konfirmasi Hapus User
            </h3>
        </div>

        <p class="text-xs sm:text-sm font-semibold text-gray-800">
            Apakah Anda yakin ingin menghapus akun user <strong id="delete_username_text" class="text-black"></strong>? Tindakan ini tidak dapat dibatalkan.
        </p>

        <form id="deleteUserForm" method="POST" action="" class="flex justify-end gap-2 border-t-2 border-black pt-4">
            @csrf
            @method('DELETE')

            <button type="button" onclick="closeDeleteUserModal()" 
                    class="border-2 border-black bg-gray-200 hover:bg-gray-300 font-bold px-4 py-1.5 text-xs uppercase cursor-pointer">
                Batal
            </button>
            <button type="submit" 
                    class="border-2 border-black bg-rose-600 hover:bg-rose-700 text-white font-bold px-4 py-1.5 text-xs uppercase cursor-pointer">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<!-- ================= MODAL TAMBAH USER BARU ================= -->
<div id="addUserModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
    <div class="relative w-full max-w-lg bg-white border-2 border-black p-6 shadow-2xl space-y-4">
        <div class="flex items-center justify-between border-b-2 border-black pb-3">
            <h3 class="text-base sm:text-lg font-black uppercase text-gray-900">
                + Tambah User Baru
            </h3>
            <button type="button" onclick="closeAddUserModal()" class="text-rose-600 hover:text-rose-800 font-bold text-xl cursor-pointer">&times;</button>
        </div>

        <form method="POST" action="{{ route('master-user.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase mb-1">Username <span class="text-rose-600">*</span></label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: budi_santoso" required 
                       class="w-full border-2 border-black p-2 text-xs sm:text-sm font-semibold focus:outline-none focus:bg-gray-50">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase mb-1">NIP (Nomor Induk Pegawai)</label>
                <input type="text" name="nip" value="{{ old('nip') }}" maxlength="18" placeholder="18 digit NIP (Opsional)"
                       class="w-full border-2 border-black p-2 text-xs sm:text-sm font-semibold focus:outline-none focus:bg-gray-50">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase mb-1">Email Dinas <span class="text-rose-600">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: budi@bkn.go.id" required 
                       class="w-full border-2 border-black p-2 text-xs sm:text-sm font-semibold focus:outline-none focus:bg-gray-50">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase mb-1">Role Access <span class="text-rose-600">*</span></label>
                <select name="role" required class="w-full border-2 border-black p-2 text-xs sm:text-sm font-bold bg-white focus:outline-none">
                    <option value="" disabled selected>-- Pilih Role --</option>
                    <option value="pegawai">Pegawai</option>
                    <option value="pimpinan">Pimpinan</option>
                    <!-- Option Admin Dihapus dari Pilihan UI -->
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase mb-1">Password <span class="text-rose-600">*</span></label>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required 
                       class="w-full border-2 border-black p-2 text-xs sm:text-sm font-semibold focus:outline-none focus:bg-gray-50">
            </div>

            <div class="flex justify-end gap-2 border-t-2 border-black pt-4">
                <button type="button" onclick="closeAddUserModal()" 
                        class="border-2 border-black bg-gray-200 hover:bg-gray-300 font-bold px-4 py-1.5 text-xs uppercase cursor-pointer">
                    Batal
                </button>
                <button type="submit" 
                        class="border-2 border-black bg-slate-900 hover:bg-slate-800 text-white font-bold px-4 py-1.5 text-xs uppercase cursor-pointer">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>

<!-- SCRIPT LOGIKA FILTER & MODAL POPUP -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('userSearchInput');
        const roleSelect = document.getElementById('roleFilterSelect');
        const rows = document.querySelectorAll('.user-row');

        function filterUsers() {
            const query = searchInput.value.toLowerCase().trim();
            const selectedRole = roleSelect.value;

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                const role = row.getAttribute('data-role');

                const matchesSearch = text.includes(query);
                const matchesRole = (selectedRole === 'all') || (role === selectedRole);

                if (matchesSearch && matchesRole) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }

        if (searchInput) searchInput.addEventListener('input', filterUsers);
        if (roleSelect) roleSelect.addEventListener('change', filterUsers);
    });

    // --- MODAL EDIT FUNCTIONS ---
    function openEditUserModal(id, username, nip, email, role) {
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_nip').value = nip !== 'null' ? nip : '';
        document.getElementById('edit_email').value = email !== 'null' ? email : '';
        document.getElementById('edit_role').value = role;

        // Set action URL form update
        document.getElementById('editUserForm').action = `/master-user/${id}`;

        document.getElementById('editUserModal').classList.remove('hidden');
    }

    function closeEditUserModal() {
        document.getElementById('editUserModal').classList.add('hidden');
    }

    // --- MODAL HAPUS FUNCTIONS ---
    function openDeleteUserModal(id, username) {
        document.getElementById('delete_username_text').innerText = username;
        
        // Set action URL form delete
        document.getElementById('deleteUserForm').action = `/master-user/${id}`;

        document.getElementById('deleteUserModal').classList.remove('hidden');
    }

    function closeDeleteUserModal() {
        document.getElementById('deleteUserModal').classList.add('hidden');
    }

 // --- MODAL TAMBAH USER FUNCTIONS ---
function openAddUserModal() {
    document.getElementById('addUserModal').classList.remove('hidden');
}

function closeAddUserModal() {
    document.getElementById('addUserModal').classList.add('hidden');
}
</script>
@endsection