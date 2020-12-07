<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    private function getCategoryCollection(&$category_collection = null)
    {
        if (is_null($category_collection))
        {
            $category_collection = new CategoryCollection([]);
            $category_array = Category::whereNull('parent_category_id')->get()->all();

            foreach ($category_array AS $category)
            {
                $category_collection->push($category);

                $child_category_array = Category::where('parent_category_id', $category->category_id)->get()->all();
                $child_category_collection = CategoryResource::collection($child_category_array);

                $this->getCategoryCollection($child_category_collection);
                $category->setRelation('child_categories', $child_category_collection->collection);
            }
        }
        else if (is_object($category_collection))
        {
            $category_array = $category_collection->all();

            foreach ($category_array AS $category)
            {
                $child_category_array = Category::where('parent_category_id', $category->category_id)->get()->all();
                $child_category_collection = CategoryResource::collection($child_category_array);

                $this->getCategoryCollection($child_category_collection);
                $category->setRelation('child_categories', $child_category_collection->collection);
            }
        }
    }

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

    public function getOptions(Request $request)
    {
        $q = $request->get('q') ?? '';
        $category_array = Category::select('category_id AS id', 'name AS text')->where('name', 'LIKE', "%$q%")->get()->all();

        return response()->json(['results' => $category_array]);
    }

    public function put(PutRequest $request)
    {
        $category_data = $request->validated();

        if (is_numeric($category_data['parent_category_id']))
        {
            Category::where('category_id', $category_data['parent_category_id'])->update([
                'number_of_descendant' => DB::raw("number_of_descendant + 1")
            ]);
        }

        Category::create($category_data);

        return response()->json(['inserted' => 1]);
    }

    public function patch(PatchRequest $request)
    {
        $category_data = $request->validated();
        $category_id = $category_data['category_id'];

        unset($category_data['category_id']);

        $category = Category::where('category_id', $category_id)->get()->first();

        if ($category->parent_category_id != $category_data['parent_category_id'])
        {
            Category::where('category_id', $category->category_id)->get()->first();

            if (is_numeric($category_data['parent_category_id']))
            {
                $number_of_descendant = intval($category->number_of_descendant ?? 0) + 1;

                Category::where('category_id', $category_data['parent_category_id'])->update([
                    'number_of_descendant' => DB::raw("number_of_descendant + $number_of_descendant")
                ]);
            }
        }

        $udpated = $category->where('category_id', $category_id)->update($category_data);

        return response()->json(['updated' => $udpated]);
    }

    public function destroy(DeleteRequest $request)
    {
        $category_data = $request->validated;
        Category
        ::leftJoin(DB::raw('categories AS c'), 'c.parent_category_id', '=', 'categories.category_id')
        ->whereIn('c.category_id', $category_data['category_id'])
        ->update([
            'number_of_descendant' => DB::raw('number_of_descendant - c.number_of_descendant')
        ]);

        $deleted = Category::whereIn('category_id', $category_data['category_id'])->delete();

        return response()->json(['deleted' => $deleted]);
    }
}
