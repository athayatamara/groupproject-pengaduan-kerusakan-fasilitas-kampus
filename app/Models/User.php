<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'identity_number',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Label peran untuk ditampilkan: $user->role_label
    public function getRoleLabelAttribute(): string
    {
        return [
            'admin' => 'Admin Sarpras',
            'mahasiswa' => 'Mahasiswa',
            'dosen_tendik' => 'Dosen/Tendik',
        ][$this->role] ?? ucfirst($this->role);
    }
}
