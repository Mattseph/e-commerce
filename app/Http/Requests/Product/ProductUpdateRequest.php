<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'title' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer'],
            'description' => ['nullable', 'string', 'max:1000'],
            // 'published' => ['nullable', 'boolean'],
            // 'inStock' => ['nullable', 'boolean'],
            'price' => ['required'],
            'existing_product_images.*' => ['nullable', 'string'],
            'new_product_images.*' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif'],
            'updated_by' => ['nullable', 'integer'],
        ];
    }

    public function attributes() {
        return [
            'category_id' => 'category',
            'brand_id' => 'brand',
            'title' => 'product title',
            'quantity' => 'product quantity',
            'description' => 'product description',
            'price' => 'product price',
            'new_product_images.*' => 'product images',
        ];
    }
}
