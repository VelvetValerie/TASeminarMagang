<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama tabel di database Anda
    protected $table = 'berita'; 

    // Tentukan primary key jika tidak menggunakan default 'id'
    // (Jika di database Anda namanya 'id', baris ini bisa dihapus)
    protected $primaryKey = 'id_berita'; 

    // Kolom-kolom yang diizinkan untuk diisi secara massal (Mass Assignment)
    protected $fillable = [
        'judul_berita',
        'slug',
        'konten',
        'status',
        'thumbnail',     // Opsional: jika nanti ada fitur upload gambar sampul
        'lampiran_url',
        'id_penulis',       // Menyimpan ID admin yang membuat/mengunggah
    ];

    /**
     * Relasi ke model User atau Pegawai (Penulis Berita)
     * Ini digunakan pada pemanggilan $berita->penulis->nama_karyawan di blade
     */
    public function penulis()
    {
        // Ganti 'User::class' dengan model yang Anda gunakan untuk Master User/Karyawan
        // 'id_user' adalah foreign key di tabel berita, 'id' adalah primary key di tabel user
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}