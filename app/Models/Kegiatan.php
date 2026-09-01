<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id_keg';
    protected $guarded = [];

    public function jenis()
    {
        return $this->belongsTo(JenisKeg::class, 'id_jeniskeg');
    }

    public function lokasi()
    {
        return $this->belongsTo(TitikLokasi::class, 'id_tklokasi');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi');
    }

    public function koordinator()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan_koor');
    }
}