<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\CategoryController;
use App\Models\Product;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use App\Models\Product_2_Category;

class ProductController extends Controller
{
    public function get()
    {
        $product_array =
        Product
        ::select('product_id', 'name', 'price', 'image', DB::raw("CONCAT('/product/', slug) as url"))
        ->paginate(12);

        return new ProductCollection($product_array);
    }

    public function getDetail(Request $request, $slug)
    {
        $product =
        Product
        ::select('product_id', 'name', 'description', 'price', 'quantity', 'image', DB::raw("CONCAT('/product/', slug) as url"))
        ->where('slug', $slug)
        ->get()
        ->first();

        return new ProductResource($product);
    }

    private function getCategoryFamilyByCategorySlug(string $category_slug, array $categories = [])
    {
        $category = Category::where('slug', $category_slug)->get()->first();

        if (is_object($category))
        {
            array_unshift($categories, $category);

            if (is_numeric($category->parent_category_id))
            {
                $category2 = Category::where('category_id', $category->parent_category_id)->get()->first();

                if (is_object($category2))
                {
                    array_unshift($categories, $category2);

                    $this->getFamilyCategories($category2->slug, $categories);
                }
            }
        }

        return $categories;
    }

    private function getParentCategoryCollection(Category $category, &$parent_category_collection)
    {
        if (is_numeric($category->parent_category_id))
        {
            $parent_category = Category::select('name', 'slug', 'parent_category_id')->where('category_id', $category->parent_category_id)->get()->first();

            if (is_object($parent_category))
            {
                $parent_category_collection->prepend($parent_category);

                $this->getParentCategoryCollection($parent_category, $parent_category_collection);
            }
        }
    }

    private function getParentCategoryCollectionByProduct(Product $product, &$parent_category_collection)
    {
        $product_2_category_array =
        Product_2_category
        ::where('product_id', $product->product_id)
        ->leftJoin('categories', 'categories.category_id', '=', 'product_2_categories.category_id')
        ->get()
        ->all();

        dump($product_2_category_array);
    }

    public function getProductsByCategorySlugs(Request $request, $url)
    {
        $category_slug_array = explode('/', $url);
        $category_slug = last($category_slug_array);
        $category = Category::where('slug', $category_slug)->get()->first();

        if (is_null($category))
        {
            abort(404);
        }

        $parent_category_collection = CategoryResource::collection([]);

        $parent_category_collection->push($category);
        $this->getParentCategoryCollection($category, $parent_category_collection);

        $parent_category_array = $parent_category_collection->all();
        $category_slug_array = [];
        $category_data_array = [];

        foreach ($parent_category_array AS $parent_category)
        {
            array_push($category_slug_array, $parent_category->slug);
            array_push($category_data_array, [
                'name' => $parent_category->name,
                'url' => '/category/'.implode('/', $category_slug_array)
            ]);
        }

        $category_slugs = implode('/', $category_slug_array);

        if (strpos($url, $category_slugs) !== 0)
        {
            abort(404);
        }

        $product_array =
        Product
        ::select('products.product_id', 'products.name', DB::raw("CONCAT('/product/', products.slug) AS url"), 'products.image', 'products.price')
        ->leftJoin('product_2_categories', 'product_2_categories.product_id', '=', 'products.product_id')
        ->where('product_2_categories.category_id', $category->category_id)
        ->get()
        ->all();

        foreach ($product_array AS $product)
        {
            $product->price = floatval($product->price);
        }

        return response()->json([
            'data' => $product_array,
            'meta' => [
                'category' => array_pop($category_data_array),
                'parent_categories' => $category_data_array
            ]
        ]);
    }

    public function getNewestProducts()
    {
        $product_array =
        Product
        ::select('product_id', 'name', 'price', 'image', DB::raw("CONCAT('/product/', slug) as url"))
        ->limit(6)
        ->get()
        ->all();
        $category_collection;

        $this->getParentCategoryCollectionByProduct($product_array[0], $category_collection);

        return new ProductCollection($product_array);
    }

    public function getMostViewedProducts()
    {
        $product_array =
        Product
        ::select('product_id', 'name', 'price', 'image', DB::raw("CONCAT('/product/', slug) as url"))
        ->orderBy('viewed', 'desc')
        ->limit(6)
        ->get()
        ->all();

        return new ProductCollection($product_array);
    }
}
