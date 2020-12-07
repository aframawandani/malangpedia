<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class PutRequest extends FormRequest
{
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
        return [
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,jpg,png',
            'quantity' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0'
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
            'quantity.numeric' => 'Jumlah harus berupa angka positif atau nol',
            'quantity.min' => 'Jumlah harus berupa angka positif atau nol',
            'price.numeric' => 'Harga harus berupa angka positif atau nol',
            'price.min' => 'Harga harus berupa angka positif atau nol'
        ];
    }
}
