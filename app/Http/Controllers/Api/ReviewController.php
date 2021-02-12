<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Review\PutRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    public function get(Request $request, $product_slug)
    {
        $review_paginator =
        Review
        ::select('reviews.review_id', 'users.name AS user_name', 'reviews.content', 'reviews.rating', 'reviews.created_at')
        ->leftJoin('users', 'users.id', '=', 'reviews.user_id')
        ->leftJoin('products', 'products.product_id', '=', 'reviews.product_id')
        ->where('products.slug', $product_slug)
        ->paginate(10);

        return response()->json($review_paginator);
    }

    public function put(PutRequest $request)
    {
        $user = $request->user();
        $review_data = $request->validated();

        $review = Review::where('product_id', $review_data['product_id'])->where('user_id', $user->id)->get()->first();

        if (is_object($review))
        {
            $review->update($review_data);
        }
        else {            
            $review_data['user_id'] = $user->id;

            Review::create($review_data);
        }

        return response()->json(['created' => 1], 201);
    }
}
