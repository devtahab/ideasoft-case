<?php

namespace App\Discounts;

use App\Discounts\Discount;

class Category2Buy6Get1 implements Discount {
    public function apply(array $orderItems, float $subtotal): ?array {
        $totalDiscount = 0;
        $categoryName = '';

        foreach($orderItems as $orderItem){
            if($orderItem['product']->category_id === 2 && $orderItem['quantity'] >=6){
                if($categoryName === ''){
                    $categoryName = $orderItem['product']->category->name;
                }

                $totalDiscount += ($orderItem['unit_price'] * floor($orderItem['quantity'] / 6));
            }
        }

        if($totalDiscount === 0){
            return null;
        }

        return [
            'reason' => "{$categoryName} kategorisinden ait bir üründen 6 adet alana 1 ürün ücretsiz",
            'amount' => round($totalDiscount, 2)
        ];
    }
}