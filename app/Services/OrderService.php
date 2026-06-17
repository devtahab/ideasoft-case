<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService {
    public function __construct(private DiscountService $discountService){

    }

    public function create(array $data): Order {
        return DB::transaction(function() use ($data){
            $subtotal = 0;
            $orderItems = [];

            foreach($data['items'] as $item){
                $product = Product::query()->lockForUpdate()->find($item['product_id']);

                if($product->stock < $item['quantity']){
                    throw new \Exception("{$product->name} stok yeterli değil");
                }

                $lineTotal = $product->price * $item['quantity'];
                $subtotal += $lineTotal;

                $orderItems[] = [
                    'product' => $product,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'line_total' => $lineTotal
                ];
            }

            $discountResult = $this->discountService->calculate($orderItems, $subtotal);

            $order = Order::create([
                'customer_id' => $data['customer_id'],
                'subtotal' => $subtotal,
                'discount_total' => $discountResult['total_discount'],
                'total' => $subtotal - $discountResult['total_discount'],
                'status' => 'pending'
            ]);

            foreach($discountResult['discounts'] as $discount){
                $order->discounts()->create([
                    'reason' => $discount['reason'],
                    'amount' => $discount['amount']
                ]);
            }

            foreach($orderItems as $orderItem){
                $order->items()->create([
                    'product_id' => $orderItem['product_id'],
                    'quantity' => $orderItem['quantity'],
                    'unit_price' => $orderItem['unit_price'],
                    'line_total' => $orderItem['line_total']
                ]);

                $orderItem['product']->decrement('stock', $orderItem['quantity']);
            }

            $order->customer()->increment('revenue', $order->total);

            return $order->load(['items', 'discounts']);
        });
    }

    public function preview(array $data): array {
        $subtotal = 0;
        $orderItems = [];

        foreach($data['items'] as $item) {
            $product = Product::query()->find($item['product_id']);

            $lineTotal = $product->price * $item['quantity'];
            $subtotal += $lineTotal;

            $orderItems[] = [
                'product' => $product,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'line_total' => $lineTotal
            ];
        }

        $discountResult = $this->discountService->calculate($orderItems, $subtotal);
        
        return [
            'subtotal' => $subtotal,
            'discounts' => $discountResult['discounts'],
            'discount_total' => $discountResult['total_discount'],
            'total' => $subtotal - $discountResult['total_discount']
        ];
    }
}