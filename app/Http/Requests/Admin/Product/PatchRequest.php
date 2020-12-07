<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PatchRequest extends FormRequest
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
        $product_id = $this->get('product_id');

        return [
            'product_id' => 'required|exists:products,product_id',
            'name' => 'required',
            'slug' => "required|unique:products,slug,$product_id,product_id",
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,jpg,png',
            'quantity' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0'
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
            'quantity.numeric' => 'Jumlah harus berupa angka positif atau nol',
            'quantity.min' => 'Jumlah harus berupa angka positif atau nol',
            'price.numeric' => 'Harga harus berupa angka positif atau nol',
            'price.min' => 'Harga harus berupa angka positif atau nol'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $jsonResponse = response()->json(['errors' => $validator->errors()], 422);

        throw new HttpResponseException($jsonResponse);
    }
}
