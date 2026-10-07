<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'outlet_id', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function isAdmin(): bool  { return $this->role === 'admin'; }
    public function isKasir(): bool  { return $this->role === 'kasir'; }
    public function isOwner(): bool  { return $this->role === 'owner'; }

    public function outlet()       { return $this->belongsTo(Outlet::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
    public function logs()         { return $this->hasMany(SystemLog::class); }
}
