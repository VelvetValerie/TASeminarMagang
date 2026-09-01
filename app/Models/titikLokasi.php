<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitikLokasi extends Model
{
    protected $table = 'titik_lokasi';
    protected $primaryKey = 'id_tklokasi';
    public $timestamps = false;
    protected $guarded = [];
}