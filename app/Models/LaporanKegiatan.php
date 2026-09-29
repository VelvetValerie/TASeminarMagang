<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKegiatan extends Model
{
    protected $table = 'laporan_kegiatan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_keg',
        'peserta_hadir',
        'peserta_tidak_hadir',
        'nilai_tertinggi',
        'nilai_terendah',
        'lampiran_laporan',
        'catatan_evaluasi',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_keg', 'id_keg');
    }
}