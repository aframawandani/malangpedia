<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Product/Index');
    }

    public function single(Request $request, $product_slug)
    {
        $user = $request->user();

        return Inertia::render('Product/Single', [
            'productSlug' => $product_slug
        ])->with(['isUserLoggedIn' => is_object($user)]);
    }
}
