<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'email', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function users() { return $this->hasMany(User::class); }
    public function customers() { return $this->hasMany(Customer::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
}
