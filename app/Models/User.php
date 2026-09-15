<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'nip',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // ========================================================
    // NONAKTIFKAN FITUR REMEMBER TOKEN KARENA KOLOM TIDAK ADA
    // ========================================================
    public function getRememberTokenName()
    {
        return ''; // Kosongkan nama kolom remember token
    }

    public function setRememberToken($value)
    {
        // Jangan lakukan apa-apa saat Laravel mencoba menyimpan token
    }

    public function getRememberToken()
    {
        return null;
    }
}