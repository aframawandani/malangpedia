<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Category/Index');
    }

    public function single(Request $request)
    {
        $page = is_numeric(@$request->page) ? intval($request->page) : null;

        return Inertia::render('Category/Single')->with(['page' => $page]);
    }
}
