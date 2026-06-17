<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    protected $fillable = [
        'order_id',
        'reason',
        'amount'
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
