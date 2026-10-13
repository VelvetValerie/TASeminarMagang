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
        'konten',
        'status',
        'thumbnail',
        'lampiran_url',
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