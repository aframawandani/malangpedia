<?php

namespace App\Http\Requests\Order;

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
        $order_2_product_data_array = $this->get('products') ?? [];
        $rules = [
            'address' => 'required',
            'note' => 'nullable',
            'products' => 'required|array'
        ];

        foreach ($order_2_product_data_array AS $i => $order_2_product_data)
        {
            $rules["products.$i.product_id"] = 'required|exists:products,product_id';
            $rules["products.$i.quantity"] = 'required|numeric|min:1';
        }

        return $rules;
    }

    public function messages()
    {
        $order_2_product_data_array = $this->get('products') ?? [];
        $messages = [
            'address.required' => 'Alamat harus diisi',
            'products.required' => 'Produk masih kosong',
            'products.array' => 'Produk tidak valid'
        ];

        foreach ($order_2_product_data_array AS $i => $order_2_product_data)
        {
            $no = $i + 1;
            $rules["products.$i.product_id.required"] = "Produk nomor $no harus diisi";
            $rules["products.$i.product_id.exists"] = "Produk nomor $no tidak valid";
            $rules["products.$i.quantity.required"] = "Kuantitas nomor $no harus diisi";
            $rules["products.$i.quantity.numeric"] = "Kuantitas nomor $no harus berupa angka";
            $rules["products.$i.quantity.min"] = "Kuantitas nomor $no minimal 1";
        }

        return $messages;
    }
}
