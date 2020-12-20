<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingCartProduct\PutRequest;
use App\Http\Requests\ShoppingCartProduct\PatchRequest;
use App\Http\Requests\ShoppingCartProduct\DeleteRequest;
use App\Http\Resources\ShoppingCartProductResource;
use App\Http\Resources\ShoppingCartProductCollection;
use App\Models\Product;
use App\Models\Shopping_cart_product;

class ShoppingCartProductController extends Controller
{
    private function map($shopping_cart_product_collection)
    {
        return $shopping_cart_product_collection->map(function ($shopping_cart_product)
        {
            return [
                'product_id' => $shopping_cart_product->product_id,
                'name' => $shopping_cart_product->name,
                'quantity' => $shopping_cart_product->quantity,
                'price' => is_numeric($shopping_cart_product->price) ? floatval($shopping_cart_product->price) : null,
                'image' => $shopping_cart_product->image
            ];
        });
    }

    public function get()
    {
        global $user;

        $shopping_cart_product_array =
        Shopping_cart_product
        ::select('shopping_cart_products.shopping_cart_product_id', 'shopping_cart_products.product_id', 'products.name', 'products.price', 'shopping_cart_products.quantity', DB::raw("CONCAT('/assets/images/products/', products.image, '.jpg') AS image"))
        ->leftJoin('products', 'products.product_id', '=', 'shopping_cart_products.product_id')
        ->where('user_id', $user->id)
        ->get()
        ->all();

        $shopping_cart_product_collection = (new ShoppingCartProductCollection($shopping_cart_product_array))->transform(function ($shopping_cart_product)
        {
            $shopping_cart_product->price = floatval($shopping_cart_product->price);

            return $shopping_cart_product;
        });

        return response()->json(['data' => $shopping_cart_product_collection]);
    }

    public function put(PutRequest $request)
    {
        global $user;

        $shopping_cart_product_data = $request->validated();
        $shopping_cart_product_data['user_id'] = $user->id;
        $shopping_cart_product =
        Shopping_cart_product
        ::where('shopping_cart_products.user_id', $user->id)
        ->where('shopping_cart_products.product_id', $shopping_cart_product_data['product_id'])
        ->get()
        ->first();
        $status = 200;

        if (is_object($shopping_cart_product))
        {
            $shopping_cart_product->update(['quantity' => $shopping_cart_product->quantity + intval($shopping_cart_product_data['quantity'])]);

            unset($shopping_cart_product->shopping_cart_product_id, $shopping_cart_product->user_id, $shopping_cart_product->product_id, $shopping_cart_product->created_at, $shopping_cart_product->updated_at);
        }
        else if (is_null($shopping_cart_product))
        {
            $shopping_cart_product_id = Shopping_cart_product::select('*')->create($shopping_cart_product_data)->shopping_cart_product_id;
            $shopping_cart_product = Shopping_cart_product
            ::select('shopping_cart_products.shopping_cart_product_id', 'shopping_cart_products.product_id', 'products.name', 'products.price', 'shopping_cart_products.quantity', 'products.image')
            ->leftJoin('products', 'products.product_id', '=', 'shopping_cart_products.product_id')
            ->where('shopping_cart_products.user_id', $user->id)
            ->where('shopping_cart_products.product_id', $shopping_cart_product_data['product_id'])
            ->get()
            ->first();
            $shopping_cart_product->price = floatval($shopping_cart_product->price);
            $status = 201;
        }

        return response()->json(['data' => $shopping_cart_product], $status);
    }

    public function patch(PatchRequest $request)
    {
        global $user;

        $shopping_cart_product_data = $request->validated();
        $product_id = $shopping_cart_product_data['product_id'];

        unset($shopping_cart_product_data['product_id']);

        $shopping_cart_product = Shopping_cart_product::where('user_id', $user->id)->where('product_id', $product_id)->get()->first();

        $shopping_cart_product->update($shopping_cart_product_data);

        return response()->json(['data' => [
            'quantity' => $shopping_cart_product->quantity
        ]]);
    }

    public function destroy(DeleteRequest $request)
    {
        global $user;

        $shopping_cart_product_data = $request->validated();

        $deleted = Shopping_cart_product::where('user_id', $user->id)->whereIn('product_id', $shopping_cart_product_data['product_id'])->delete();

        return response()->json(['deleted' => $deleted]);
    }
}
