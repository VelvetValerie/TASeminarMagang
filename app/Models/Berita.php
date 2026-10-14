<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita'; 
    protected $primaryKey = 'id_berita'; 

    protected $fillable = [
        'judul_berita',
        'slug',
        'kategori_publikasi',
        'konten',
        'status',
        'lampiran_url',
        'thumbnail',
        'caption_thumbnail',
        'id_penulis',
    ];

    /**
     * Relasi ke model User (Penulis Berita)
     */
    public function penulis()
    {
        return $this->belongsTo(User::class, 'id_penulis', 'id_user');
    }
}