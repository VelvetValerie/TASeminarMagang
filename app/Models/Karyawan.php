<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $guarded = [];

    public function rekamKerja()
    {
        return $this->hasMany(RekamKj::class, 'id_karyawan');
    }
}