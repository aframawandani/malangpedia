<?php

namespace App\Http\Controllers\Web\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Order/Index');
    }
}
