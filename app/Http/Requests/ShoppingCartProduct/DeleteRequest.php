<?php

namespace App\Http\Requests\ShoppingCartProduct;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class DeleteRequest extends FormRequest
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
            'product_id' => "required|array|min:1"
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Product Id harus diisi',
            'product_id.array' => 'Format Product Id tidak valid',
            'product_id.min' => 'Product Id harus diisi minimal 1'
        ];
    }
}
