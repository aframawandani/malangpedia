<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'product_id' => 'required|exists:products,product_id',
            'content' => 'required',
            'rating' => 'required|in:1,2,3,4,5',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Id Produk harus diisi',
            'product_id.exists' => 'Produk tidak valid',
            'content.required' => 'Content harus diisi',
            'rating.required' => 'Rating harus diisi',
            'rating.in' => 'Rating harus antara 1 sampai 5',
        ];
    }
}
