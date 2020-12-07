<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\PutRequest;
use App\Http\Resources\Order2ProductResource;
use App\Models\Order;
use App\Models\Order_2_product;

class OrderController extends Controller
{
    public function get()
    {
        $order_array = Order::select('order_id');
    }

    public function put(PutRequest $request)
    {
        global $user;

        $order_data = $request->validated();
        $order_data['user_id'] = $user->id;
        $order_2_product_data_array = $order_data['products'];

        unset($order_data['products']);

        $order = Order::create($order_data);

        foreach ($order_2_product_data_array AS $order_2_product_data)
        {
            $order_2_product_data['order_id'] = $order->order_id;

            Order_2_product::create($order_2_product_data);
        }

        return response()->json(['data' => $order]);
    }
}
