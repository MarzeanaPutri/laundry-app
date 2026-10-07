<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = ['transaction_id', 'product_id', 'quantity', 'price', 'subtotal'];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price'    => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function transaction() { return $this->belongsTo(Transaction::class); }
    public function product()     { return $this->belongsTo(Product::class); }
}
