<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'subtotal',
        'discount_total',
        'total',
        'status'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function discounts() {
        return $this->hasMany(OrderDiscount::class);
    }
}
