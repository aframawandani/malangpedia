<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Order/Index');
    }

    public function single(Request $request, $order_id)
    {
        return Inertia::render('Order/Single')->with('orderId', intval($order_id));
    }
}
