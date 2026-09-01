<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKeg extends Model
{
    protected $table = 'jenis_keg';
    protected $primaryKey = 'id_jeniskeg';
    public $timestamps = false;
    protected $guarded = [];
}