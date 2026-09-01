<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamKj extends Model
{
    protected $table = 'rekam_kj';
    protected $primaryKey = 'id_kj';
    public $timestamps = false;
    protected $guarded = [];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_keg');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}