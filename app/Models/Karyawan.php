<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $guarded = [];

    /**
     * Relasi ke model Kegiatan
     */
    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'id_karyawan_koor', 'id_karyawan');
    }

    public function rekamKerja()
    {
        return $this->hasMany(RekamKj::class, 'id_karyawan', 'id_karyawan');
    }
}