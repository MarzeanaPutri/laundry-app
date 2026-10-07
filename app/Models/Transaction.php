<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'invoice_number', 'customer_id', 'outlet_id', 'user_id',
        'status', 'payment_status', 'total_amount', 'paid_amount',
        'estimated_done', 'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_amount'  => 'decimal:2',
        'estimated_done' => 'date',
    ];

    public static function generateInvoice(): string
    {
        $prefix = 'INV-' . date('Ymd');
        $last = static::where('invoice_number', 'like', $prefix . '%')->count();
        return $prefix . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }

    public function customer() { return $this->belongsTo(Customer::class); }
    public function outlet()   { return $this->belongsTo(Outlet::class); }
    public function user()     { return $this->belongsTo(User::class); }
    public function items()    { return $this->hasMany(TransactionItem::class); }
}
