<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class ShopppingCartController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('ShoppingCart/Index');
    }
}
