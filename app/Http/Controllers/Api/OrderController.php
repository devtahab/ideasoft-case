<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StoreOrderPreviewRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
        
    }

    public function store(StoreOrderRequest $request) {
        try {
            $validated = $request->validated();

            $order = $this->orderService->create($validated);

            return response()->json([
                'message' => 'Order created successfully',
                'data' => $order
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 422);
        }
    }

    public function preview(StoreOrderPreviewRequest $request) {
        $validated = $request->validated();

        $order = $this->orderService->preview($validated);

        return response()->json([
            'data' => $order
        ], 200);
    }
}
