<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\ShoppingCartProductResource;
use App\Models\Product;
use Closure;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        global $user, $shopping_cart_product_collection;

        $shopping_cart_product_collection = Session::get('shopping_cart_product_collection');
        $user = $request->user();

        if (is_null($user))
        {
            return response()->json(null, 404);
        }

        if (is_null($shopping_cart_product_collection))
        {
            $shopping_cart_product_collection = ShoppingCartProductResource::collection([]);

            Session::put('shopping_cart_product_collection', $shopping_cart_product_collection);
        }

        return $next($request);
    }
}
