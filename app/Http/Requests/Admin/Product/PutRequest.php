<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic;

class PutRequest extends FormRequest
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
        $image_file = $this->file('image');

        return [
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
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
            'category_ids' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi',
            'slug.required' => 'Slug harus diisi',
            'slug.unique' => 'Slug sudah terdaftar',
            'image.image' => 'Gambar harus berupa file gambar jpeg, jpg atau png',
            'image.mimes' => 'Gambar harus berupa file gambar jpeg, jpg atau png',
            '_image.required' => 'Lebar atau tinggi gambar harus lebih dari atau sama dengan 300px',
            'quantity.numeric' => 'Jumlah harus berupa angka positif atau nol',
            'quantity.min' => 'Jumlah harus berupa angka positif atau nol',
            'price.numeric' => 'Harga harus berupa angka positif atau nol',
            'price.min' => 'Harga harus berupa angka positif atau nol',
            'category_ids.required' => 'Kategori harus diisi',
            'category_ids.array' => 'Kategori tidak valid'
        ];
    }
}
