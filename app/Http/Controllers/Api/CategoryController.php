<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Category\PutRequest;
use App\Http\Requests\Api\Category\PatchRequest;
use App\Http\Requests\Api\Category\DeleteRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;

class CategoryController extends Controller
{
    public static function getParentCategories(Category $category, array $categories = [])
    {
        if (is_numeric($category->parent_category_id))
        {
            $category2 = Category::where('category_id', $category->parent_category_id)->get()->first();

            array_unshift($categories, $category2);

            self::getParentCategories($category2, $categories);
        }

        return $categories;
    }

    public static function getParentCategorySlugs(Category $category)
    {
        $category_array = self::getParentCategories($category);
        $category_slug_array = [];

        foreach ($category_array AS $category)
        {
            array_push($category_slug_array, $category->slug);
        }

        return $category_slug_array;
    }

    public static function getCategorySlugsByProduct(Product $product)
    {
        $product_2_category_array = Product_2_category
        ::select('categories.category_id', 'categories.slug')
        ->leftJoin('categories', 'categories.category_id', '=', 'product_2_categories')
        ->where('products.product_id', $product->product_id)
        ->get()
        ->all();

        $category_slug_array = [];

        foreach ($product_2_category_array AS $product_2_category)
        {
            $category_slug_array2 = [];
            $category = Category::where('category_id', $product_2_category->category_id)->get()->first();

            if (is_object($category))
            {
                $category_slug_array2 = self::getParentCategorySlugs($category);
            }

            array_push($category_slug_array2, $product_2_category->slug);
            array_push($category_slugs, $category_slug_array);
        }

        return $category_slug_array;
    }

    private function getCategoryCollection(&$category_collection = null)
    {
        if (is_null($category_collection))
        {
            $category_collection = CategoryResource::collection([]);
            $category_array = Category::select('category_id', 'name', DB::raw("CONCAT('/category/', slug) AS url"))->whereNull('parent_category_id')->get()->all();

            foreach ($category_array AS $category)
            {
                $category_url = $category->url;

                $category_collection->push($category);

                $child_category_collection = CategoryResource::collection([]);
                $child_category_array = Category::select('category_id', 'name', DB::raw("CONCAT('$category_url/', slug) AS url"))->where('parent_category_id', $category->category_id)->get()->all();

                $this->getCategoryCollection($child_category_collection);

                foreach ($child_category_array AS $child_category)
                {
                    $child_category_collection->push($child_category);
                }

                $category->setRelation('child_categories', $child_category_collection->collection);
            }
        }
        else if (is_object($category_collection))
        {
            $category_array = $category_collection->all();

            foreach ($category_array AS $category)
            {
                $category_url = $category->url;
                $child_category_array = Category::select('category_id', 'name', DB::raw("CONCAT('$category_url/', slug) AS url"))->where('parent_category_id', $category->category_id)->get()->all();
                $child_category_collection = CategoryResource::collection([]);

                foreach ($child_category_array AS $child_category)
                {
                    $child_category_collection->push($child_category);
                }

                $this->getCategoryCollection($child_category_collection);
                $category->setRelation('child_categories', $child_category_collection->collection);
            }
        }
    }

    public function get(Request $request)
    {
        $category_collection = null;

        $this->getCategoryCollection($category_collection);

        return $category_collection;
    }

    public function getSingle()
    {
        return response()->json();
    }

    public function put(PutRequest $request)
    {
        $validated = $request->validated();

        Category::create($validated);
    }

    public function patch(PatchRequest $request)
    {

    }

    public function delete(DeleteRequest $request)
    {

    }
}
