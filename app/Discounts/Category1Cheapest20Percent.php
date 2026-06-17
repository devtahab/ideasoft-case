<?php

namespace App\Discounts;

use App\Discounts\Discount;

class Category1Cheapest20Percent implements Discount {
    public function apply(array $orderItems, float $subtotal): ?array {
        $count = 0;
        $cheapestPrice = null;
        $cheapestLineTotal = null;
        $categoryName = '';

        foreach($orderItems as $orderItem){
            if($orderItem['product']->category_id === 1){
                $count += $orderItem['quantity'];

                if($cheapestPrice === null || $orderItem['unit_price'] < $cheapestPrice){
                    $categoryName = $orderItem['product']->category->name;
                    $cheapestPrice = $orderItem['unit_price'];
                    $cheapestLineTotal = $orderItem['line_total'];
                }
            }
        }

        if($count < 2){
            return null;
        }

        $result = round(($cheapestLineTotal * 0.20), 2);

        return [
            'reason' => "{$categoryName} kategorisinden 2 veya daha fazla ürün alana en ucuz üründe 20% indirim",
            'amount' => $result
        ];
    }
}