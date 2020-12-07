<?php

namespace App\Http\Requests\ShoppingCartProduct;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class PatchRequest extends FormRequest
{
    public $shopping_cart_product_collection;

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
            'product_id' => "required|exists:products,product_id",
            'quantity' => "required|numeric|min:1"
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Product Id harus diisi',
            'product_id.exists' => 'Product Id tidak terdaftar',
            'quantity.required' => 'Kuantitas harus diisi',
            'quantity.numeric' => 'Kuantitas harus berupa angka',
            'quantity.min' => 'Kuantitas minimal 1'
        ];
    }
}
