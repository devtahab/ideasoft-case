<?php

namespace App\Discounts;

interface Discount {
    public function apply(array $orderItems, float $subtotal): ?array;
}