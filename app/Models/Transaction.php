<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'status',
        'total_amount',
        'shipping_fee',
        'payment_method',
        'payment_gateway_id',
        'paid_at',
    ];

    protected $casts = [
        'total_amount' => 'integer',
        'shipping_fee' => 'integer',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function getTotalAmountWithShippingAttribute()
    {
        return $this->total_amount + $this->shipping_fee;
    }
}
