<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer'],
            'brand_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer'],
            'description' => ['nullable', 'string', 'max:1000'],
            'published' => ['nullable', 'boolean'],
            'inStock' => ['nullable', 'boolean'],
            'price' => ['required', 'decimal', ],
            'image' => ['nullable', 'string', 'mimes:png,jpg,jpeg,gif'],
            'created_by' => ['nullable', 'integer'],
        ];
    }
}
