<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index() {
        return response()->json(Customer::all());
    }

    public function orders(int $id) {
        $customer = Customer::query()->findOrFail($id);

        return $customer->load(['orders.items', 'orders.discounts', 'orders.items.product']);
    }
}
