<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

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
            'slug' => 'nullable|unique:categories',
            'description' => 'nullable',
            'parent_category_id' => 'nullable|exists:categories,category_id',
            'image' => 'nullable|image',
            'sort_order' => 'nullable|numeric|min:0|max:255'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi',
            'slug.unique' => 'Slug sudah ada',
            'parent_category_id.exists' => 'Kategori Induk tidak valid',
            'image.image' => 'Gambar harus berupa file gambar jpeg, png, bmp, gif, svg, atau webp',
            'sort_order.numeric' => 'Urutan harus berupa angka',
            'sort_order.min' => 'Urutan harus lebih atau sama dengan 0',
            'sort_order.max' => 'Urutan harus kurang dari atau sama dengan 255',
            'status.numeric' => 'Status tidak valid',
            'status.in' => 'Status tidak valid'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $jsonResponse = response()->json(['errors' => $validator->errors()], 422);

        throw new HttpResponseException($jsonResponse);
    }
}
