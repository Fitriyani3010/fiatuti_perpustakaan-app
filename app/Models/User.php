<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
    'name',
    'email',
    'password',
    'no_telepon',
    'kelas', // 🔥 tambahin ini
    'alamat',
    'nisn'
];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isKepala(): bool
    {
        return $this->role === 'kepala_perpustakaan';
    }
    public function getRoleLabel(): string
    {
        return match ($this->role) {
            'user'                => 'User / Anggota',
            'petugas'             => 'Petugas Perpustakaan',
            'kepala_perpustakaan' => 'Kepala Perpustakaan',
            default               => 'Unknown',
        };
    }
}
