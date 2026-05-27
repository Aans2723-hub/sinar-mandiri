<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom-kolom yang boleh diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Kolom-kolom yang harus disembunyikan (misalnya saat data diubah ke bentuk JSON).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mengatur tipe data kolom secara otomatis.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}