<?php

namespace App\Services;

use App\Discounts\Category1Cheapest20Percent;
use App\Discounts\Category2Buy6Get1;
use App\Discounts\Over1000Discount;

class DiscountService {
    private array $discounts;

    public function __construct() {
        $this->discounts = [
            new Over1000Discount(),
            new Category2Buy6Get1(),
            new Category1Cheapest20Percent()
        ];
    }

    public function calculate(array $orderItems, float $subtotal): array {
        $appliedDiscounts = [];

        foreach($this->discounts as $discount) {
            $result = $discount->apply($orderItems, $subtotal);

            if($result !== null){
                $appliedDiscounts[] = $result;
            }
        }

        return [
            'discounts' => $appliedDiscounts,
            'total_discount' => array_sum(array_column($appliedDiscounts, 'amount'))
        ];
    }
}