<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Http\Resources\Admin\Order2ProductResource;
use App\Http\Resources\Admin\OrderResource;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_2_product;

class OrderController extends Controller
{
    public function get(Request $request)
    {
        $order_builder =
        Order
        ::select('orders.order_id', 'users.name AS user_name', 'orders.address', 'orders.created_at')
        ->leftJoin('users', 'users.id', '=', 'orders.user_id')
        ->orderBy('orders.created_at', 'DESC');

        return Datatables::of($order_builder)->setTransformer(function ($order)
        {
            $order_2_product_array =
            Order_2_product
            ::select('order_2_products.order_2_product_id', 'order_2_products.order_id', 'products.product_id', 'products.name AS product_name', DB::raw("CONCAT('/product/', products.slug) AS product_url"), 'products.image AS product_image', 'products.price AS product_price', 'order_2_products.quantity')
            ->leftJoin('products', 'products.product_id', '=', 'order_2_products.product_id')
            ->where('order_2_products.order_id', $order->order_id)
            ->get()
            ->all();
            $order_2_product_collection = Order2ProductResource::collection($order_2_product_array);

            return [
                'order_id' => $order->order_id,
                'user_name' => $order->user_name,
                'address' => $order->address,
                'created_at' => strtotime($order->created_at) * 1000,
                'products' => $order_2_product_collection
            ];
        })->make();
    }
}
