<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\PutRequest;
use App\Http\Requests\Admin\Product\PatchRequest;
use App\Http\Requests\Admin\Product\DeleteRequest;
use App\Http\Resources\Admin\ProductResource;
use Yajra\Datatables\Datatables;
use App\Models\Product;
use App\Models\Product_2_category;

class ProductController extends Controller
{
    public function get()
    {
        $product_builder = Product::select('product_id', 'name', 'image', 'quantity', 'price');

        return Datatables::of($product_builder)->toJson();
    }

    public function getDetail(Request $request, $product_id)
    {
        $product =
        Product
        ::select('product_id', 'name', 'description', 'slug', 'image', 'quantity', 'price')
        ->where('product_id', $product_id)
        ->get()
        ->first();

        return new ProductResource($product);
    }

    public function put(PutRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();
        $product_data = ['owner_user_id' => $user->id];
        $validated_image = @$validated['image'];

        unset($validated['image']);

        foreach ($validated AS $name => $value)
        {
            if (!is_null($value))
            {
                $product_data[$name] = $value;
            }
        }

        if (is_object(@$validated_image))
        {
            $image = ImageManagerStatic::make($validated_image);
            $x = 0;
            $y = 0;
            $width = $image->width();
            $height = $image->height();

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

            // $image->crop($x, $y, $width, $height);

            $file_extension = @(explode('/', $image->mime))[1];
            $relative_path = '\\assets\\images\\'.$validated_image->getClientOriginalName();
            $absolute_path = public_path().$relative_path;
            $image->save($absolute_path);

            $product_data['image'] = str_replace('\\', '/', $relative_path);
        }

        // var_dump($product_data);

        // abort(404);

        // exit;

        $product = Product::create($product_data);

        foreach (@$validated['category'] ?? [] AS $category_id)
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
        $validated = $request->validated();
        $product = Product::where('product_id', $validated['product_id'])->get()->first();
        $product_data = [];
        $validated_image = @$validated['image'];
        $validated_image_size = @$_FILES['image']['size'];

        unset($validated['image']);

        foreach ($validated AS $name => $value)
        {
            if (!is_null($value))
            {
                $product_data[$name] = $value;
            }
        }

        if (is_numeric($validated_image_size))
        {
            $old_absolute_path = public_path().str_replace('/', '\\', $product->image);

            if (is_object(@$validated_image))
            {
                $image = ImageManagerStatic::make($validated_image);
                $x = 0;
                $y = 0;
                $width = $image->width();
                $height = $image->height();

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

                // $image->crop($x, $y, $width, $height);

                $file_extension = @(explode('/', $image->mime))[1];
                $relative_path = '\\assets\\images\\'.$validated_image->getClientOriginalName();
                $absolute_path = public_path().$relative_path;

                if (is_string($product->image))
                {
                    unlink($old_absolute_path);
                }

                $image->save($absolute_path);

                $product_data['image'] = str_replace('\\', '/', $relative_path);
            }
            else
            {
                unlink($old_absolute_path);

                $product_data['image'] = null;
            }
        }

        $updated = Product::where('product_id', $validated['product_id'])->update($product_data);

        foreach (@$validated['category'] ?? [] AS $category_id)
        {
            Product_2_category::create([
                'product_id' => $validated['product_id'],
                'category_id' => $category_id
            ]);
        }

        return response()->json(['updated' => $updated]);
    }

    public function destroy(DeleteRequest $request)
    {
        $validated = $request->validated();
        $deleted = Product::whereIn('product_id', $validated['product_id'])->delete();

        return response()->json([
            'deleted' => $deleted
        ]);
    }
}
