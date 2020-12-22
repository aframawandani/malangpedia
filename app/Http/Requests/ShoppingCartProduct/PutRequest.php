<?php

namespace App\Http\Requests\ShoppingCartProduct;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;

class PutRequest extends FormRequest
{
    public $product;

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
        $this->product = Product::where('product_id', intval(@$this->get('product_id')))->get()->first();
        $product_quantity = @$this->product->quantity ?? 0;

        return [
            'product_id' => 'required|exists:products,product_id',
            'quantity' => "required|numeric|min:1|max:$product_quantity"
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Produk harus diisi',
            'product_id.exists' => 'Produk tidak terdaftar',
            'quantity.required' => 'Kuantitas harus diisi',
            'quantity.numeric' => 'Kuantitas harus berupa angka',
            'quantity.min' => 'Kuantitas minimal 1',
            'quantity.max' => 'Kuantitas barang tidak cukup'
        ];
    }
}
