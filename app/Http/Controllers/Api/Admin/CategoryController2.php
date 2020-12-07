<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Requests\Admin\Category\GetDetailRequest;
use App\Http\Requests\Admin\Category\PutRequest;
use App\Http\Requests\Admin\Category\PatchRequest;
use App\Http\Requests\Admin\Category\DeleteRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function get()
    {
        $category_builder = Category::select('category_id', 'name', 'description', 'image');

        return Datatables::of($category_builder)->toJson();
    }

    public function getDetail(Request $request, $category_id)
    {
        $category =
        Category
        ::select('categories.category_id', 'categories.name', 'categories.slug', 'categories.description', 'categories.parent_category_id', 'categories2.name AS parent_category_name')
        ->leftJoin('categories AS categories2', 'categories2.category_id', '=', 'categories.parent_category_id')
        ->where('categories.category_id', $category_id)
        ->get()
        ->first();

        return new CategoryResource($category);
    }

    public function getOptions()
    {
        $category_array = Category::select('category_id AS id', 'name AS text')->get()->all();

        return response()->json(['results' => $category_array]);
    }

    public function put(PutRequest $request)
    {
        $validated = $request->validated();

        Category::create($validated);

        return response()->json(null);
    }

    public function patch(PatchRequest $request)
    {
        $validated = $request->validated();

        $udpated = Category::where('category_id', $validated['category_id'])->update($validated);

        return response()->json([
            'updated' => $udpated
        ]);
    }

    public function destroy(DeleteRequest $request)
    {
        $validated = $request->validated();
        $deleted = Category::whereIn('category_id', $validated['category_id'])->delete();

        return response()->json([
            'deleted' => $deleted
        ]);
    }
}
