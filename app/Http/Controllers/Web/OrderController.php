<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {}

    public function single(Request $request, $order_id)
    {
        return Inertia::render('Order/Single')->with('order_id', $order_id);
    }
}
