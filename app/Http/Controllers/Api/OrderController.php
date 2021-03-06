<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\PutRequest;
use App\Http\Resources\Order2ProductResource2;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Order;
use App\Models\Order_2_product;
use App\Models\Shopping_cart_product;

class OrderController extends Controller
{
    public function get(Request $request)
    {
        $user = $request->user();
        $order_array = Order::select('order_id', 'address', 'created_at')->where('user_id', $user->id)->get()->all();

        foreach ($order_array AS $order)
        {
            $order_2_product_array =
            Order_2_product
            ::select('products.name AS product_name', 'products.image AS product_image', 'products.price AS product_price', DB::raw("CONCAT('/assets/images/products/', products.image, '.jpg') AS product_image"), 'order_2_products.quantity AS quantity')
            ->leftJoin('products', 'products.product_id', '=', 'order_2_products.product_id')
            ->where('order_id', $order->order_id)
            ->get()
            ->all();

            $order_2_product_collection = Order2ProductResource2::collection($order_2_product_array);

            $order->setRelation('products', $order_2_product_collection->collection);
        }

        return OrderResource::collection($order_array);
    }

    public function getDetail(Request $request, $order_id)
    {
        $order_id = intval($order_id);

        $order = Order::select('order_id', 'address', 'note', DB::raw('status+0 AS status_idx'), 'created_at')->where('order_id', $order_id)->get()->first();

        $order_2_product_array =
        Order_2_product
        ::select('order_2_product_id', 'products.name AS product_name', 'products.image AS product_image', 'products.price AS product_price', 'order_2_products.quantity')
        ->leftJoin('products', 'products.product_id', '=', 'order_2_products.product_id')
        ->where('order_2_products.order_id', $order_id)
        ->get()
        ->all();

        $order_2_product_collection = Order2ProductResource2::collection($order_2_product_array);

        $order->setRelation('products', $order_2_product_collection->collection);

        return new OrderResource($order);
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

        Shopping_cart_product::where('user_id', $user->id)->delete();

        return response()->json(['data' => $order]);
    }
}
