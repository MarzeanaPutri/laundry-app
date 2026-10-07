<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'address', 'outlet_id'];

    public function outlet() { return $this->belongsTo(Outlet::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
}
