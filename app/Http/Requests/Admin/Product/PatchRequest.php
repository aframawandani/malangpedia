<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic;

class PatchRequest extends FormRequest
{
    public $image;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $product_id = $this->get('product_id');
        $image_file = $this->file('image');

        return [
            'product_id' => 'required|exists:products,product_id',
            'name' => 'required',
            'slug' => "required|unique:products,slug,$product_id,product_id",
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,jpg,png',
            '_image' => Rule::requiredIf(function () use($image_file)
            {
                if (is_object($image_file))
                {
                    $this->image = ImageManagerStatic::make($image_file);

                    if ($this->image->width() < 300 || $this->image->height() < 300)
                    {
                        return true;
                    }
                }

                return false;
            }),
            'quantity' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'categories' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Id Product harus diisi',
            'product_id.exists' => 'Id Product tidak terdaftar',
            'name.required' => 'Nama harus diisi',
            'slug.unique' => 'Slug sudah terdaftar',
            'image.image' => 'Gambar harus berupa file gambar jpeg, jpg atau png',
            'image.mimes' => 'Gambar harus berupa file gambar jpeg, jpg atau png',
            '_image.required' => 'Lebar atau tinggi gambar harus lebih dari atau sama dengan 300px',
            'quantity.numeric' => 'Jumlah harus berupa angka positif atau nol',
            'quantity.min' => 'Jumlah harus berupa angka positif atau nol',
            'price.numeric' => 'Harga harus berupa angka positif atau nol',
            'price.min' => 'Harga harus berupa angka positif atau nol',
            'categories.required' => 'Kategori harus diisi',
            'categories.array' => 'Kategori harus berupa array',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $jsonResponse = response()->json(['errors' => $validator->errors()], 422);

        throw new HttpResponseException($jsonResponse);
    }
}
