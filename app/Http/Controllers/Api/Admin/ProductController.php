<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\PutRequest;
use App\Http\Requests\Admin\Product\PatchRequest;
use App\Http\Requests\Admin\Product\DeleteRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use App\Models\Order_2_product;
use App\Models\Product_2_category;
use App\Models\Product_2_gallery;
use App\Models\Gallery;

class ProductController extends Controller
{
    public function get()
    {
        $product_builder =
        Product
        ::select('products.product_id', 'products.name', DB::raw("CONCAT('/assets/images/products/', products.image, '.jpg') AS image"), 'products.quantity', 'products.price', 'users.name AS owner', 'products.created_at', 'products.updated_at')
        ->leftJoin('users', 'users.id', '=', 'products.owner_user_id');

        return Datatables::of($product_builder)->setTransformer(function ($product)
        {
            $order_2_product =
            Order_2_product
            ::select(DB::raw("SUM(order_2_products.quantity) AS sold"))
            ->leftJoin('orders', 'orders.order_id', '=', 'order_2_products.order_id')
            ->where('order_2_products.product_id', $product->product_id)
            ->where('orders.status', '>', 3)
            ->where('orders.status', '<', 9)
            ->groupBy('order_2_products.product_id')
            ->get()
            ->first();

            return [
                'product_id' => $product->product_id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => is_string($product->price) ? floatval($product->price) : null,
                'quantity' => $product->quantity,
                'sold' => is_numeric(@$order_2_product->sold) ? intval(@$order_2_product->sold) : 0,
                'owner' => $product->owner,
                'created_at' => strtotime($product->created_at) * 1000,
                'updated_at' => strtotime($product->updated_at) * 1000
            ];
        })->toJson();
    }

    public function getDetail(Request $request, $product_id)
    {
        $product =
        Product
        ::select('product_id', 'name', 'description', 'slug', DB::raw("CONCAT('/assets/images/products/', image, '.jpg') AS image"), 'quantity', 'price')
        ->where('product_id', $product_id)
        ->get()
        ->first();
        $product_2_category_array =
        Product_2_category
        ::select('product_2_categories.product_2_category_id', 'product_2_categories.category_id')
        ->where('product_2_categories.product_id', $product->product_id)
        ->leftJoin('categories', 'categories.category_id', '=', 'product_2_categories.category_id')
        ->orderBy('categories.number_of_descendant', 'DESC')
        ->get()
        ->all();
        $gallery_array =
        Gallery
        ::select('gallery_id', DB::raw("CONCAT('/assets/images/galleries/', image, '.jpg') AS image"))
        ->where('product_id', $product->product_id)
        ->get()
        ->all();

        $product->setRelation('categories', $product_2_category_array);
        $product->setRelation('galleries', $gallery_array);

        return new ProductResource($product);
    }

    public function put(PutRequest $request)
    {
        $user = $request->user();
        $product_data = $request->validated();
        $product_data['owner_user_id'] = $user->id;
        $product_gallery_array = $request->file('gallery') ?? [];
        $category_id_array = $product_data['category_ids'];

        unset($product_data['image']);
        unset($product_data['category_ids']);

        if (is_object($request->image))
        {
            $uuid = (string) Str::Uuid();
            $absolute_path = public_path()."/assets/images/products/$uuid";
            $product_data['image'] = $uuid;

            $request->image->save("$absolute_path.jpg", 100, 'jpg');

            $x = 0;
            $y = 0;
            $width = $request->image->width();
            $height = $request->image->height();

            if ($width >= $height)
            {
                $x = intval(($width - $height) / 2);
                $width = $height;
            }
            else
            {
                $y = intval(($height - $width) / 2);
                $height = $width;
            }

            $request->image->crop($width, $height, $x, $y);
            $request->image->resize(300, 300);
            $request->image->save("$absolute_path.webp", 100, 'webp');
        }

        $product = Product::create($product_data);

        foreach ($product_gallery_array AS $i => $product_gallery)
        {
            $gallery_data = [
                'product_id' => $product->product_id,
                'order' => $i
            ];
            $uuid = (string) Str::Uuid();
            $absolute_path = public_path()."/assets/images/galleries/$uuid";
            $gallery_data['image'] = $uuid;
            $image = ImageManagerStatic::make($product_gallery);

            $image->save("$absolute_path.jpg", 100, 'jpg');

            Gallery::create($gallery_data);
        }

        foreach (@$category_id_array ?? [] AS $category_id)
        {
            Product_2_category::create([
                'product_id' => $product->product_id,
                'category_id' => $category_id
            ]);
        }

        return response()->json($product);
    }

    public function patch(PatchRequest $request)
    {
        $product_data = $request->validated();
        $product = Product::where('product_id', $product_data['product_id'])->get()->first();
        $gallery_insert_data_array = @$product_data['galleries']['insert'] ?? [];
        $gallery_delete_data_array = @$product_data['galleries']['delete'] ?? [];
        $product_data_image = @$request->file('image');
        $product_data_image_size = @$_FILES['image']['size'];
        $product_2_category_insert_data_array = @$product_data['categories']['insert'] ?? [];
        $product_2_category_update_data_array = @$product_data['categories']['update'] ?? [];
        $product_2_category_delete_data_array = @$product_data['categories']['delete'] ?? [];

        unset($product_data['categories']);
        unset($product_data['galleries']);

        Gallery::whereIn('gallery_id', $gallery_delete_data_array)->delete();

        $galleries_last_order = intval(@Gallery::select(DB::raw("MAX(`order`) AS `order`"))->where('product_id', $product_data['product_id'])->get()->first()->order);

        foreach ($gallery_insert_data_array AS $gallery_insert_data)
        {
            $uuid = (string) Str::Uuid();
            $absolute_path = public_path()."/assets/images/galleries/$uuid";
            $image = ImageManagerStatic::make($gallery_insert_data);

            $image->save("$absolute_path.jpg", 100, 'jpg');

            $galleries_last_order++;

            Gallery::create([
                'product_id' => $product_data['product_id'],
                'image' => $uuid,
                'order' => $galleries_last_order,
            ]);
        }

        foreach ($product_data AS $name => $value)
        {
            if (!is_null($value))
            {
                $product_data[$name] = $value;
            }
        }

        if (is_numeric($product_data_image_size))
        {
            $product_data['image'] = null;
            $public_path = public_path();

            if (is_string($product->image))
            {
                $path = "$public_path/assets/images/products/".$product->image;

                @unlink("$path.webp");
                @unlink("$path.jpg");
            }

            if (is_object(@$product_data_image))
            {
                $uuid = (string) Str::Uuid();
                $absolute_path = "$public_path/assets/images/products/$uuid";
                $product_data['image'] = $uuid;

                $request->image->save("$absolute_path.jpg", 100, 'jpg');
    
                $x = 0;
                $y = 0;
                $width = $request->image->width();
                $height = $request->image->height();
    
                if ($width >= $height)
                {
                    $x = intval(($width - $height) / 2);
                    $width = $height;
                }
                else
                {
                    $y = intval(($height - $width) / 2);
                    $height = $width;
                }

                $request->image->crop($width, $height, $x, $y);
                $request->image->resize(300, 300);
                $request->image->save("$absolute_path.webp", 100, 'webp');
            }
        }

        Product::where('product_id', $product_data['product_id'])->update($product_data);

        foreach ($product_2_category_insert_data_array AS $category_id)
        {
            Product_2_category::create([
                'product_id' => $product_data['product_id'],
                'category_id' => $category_id,
            ]);
        }

        foreach ($product_2_category_update_data_array AS $product_2_category_update_data)
        {
            $product_2_category_id = $product_2_category_update_data['product_2_category_id'];

            unset($product_2_category_update_data['product_2_category_id']);

            Product_2_category::where('product_2_category_id', $product_2_category_id)->update($product_2_category_update_data);
        }

        Product_2_category::whereIn('product_2_category_id', $product_2_category_delete_data_array)->delete();

        return response()->json(['updated' => 1]);
    }

    public function destroy(DeleteRequest $request)
    {
        $product_data = $request->validated();
        $deleted = Product::whereIn('product_id', $product_data['product_id'])->delete();

        return response()->json([
            'deleted' => $deleted
        ]);
    }
}
