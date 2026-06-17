<?php

namespace App\Discounts;

use App\Discounts\Discount;

class Over1000Discount implements Discount {
    public function apply(array $orderItems, float $subtotal): ?array {
        if($subtotal < 1000){
            return null;
        }

        return [
            'reason' => '1000 TL ve üzeri siparişe %10 indirim',
            'amount' => round((($subtotal * 10) / 100), 2)
        ];
    }
}