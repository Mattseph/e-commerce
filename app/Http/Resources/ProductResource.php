<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'published' => $this->published,
            'inStock' => $this->inStock,
            'quantity' => $this->quantity,
            'price' => $this->price,
            // 'brand_avg' => $this->whenAggregated('brand', 'name', 'avg'),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'brand' => BrandResource::make($this->whenLoaded('brand')),
            'product_images' => ProductImageResource::collection($this->whenLoaded('product_images')),
            'created_at' => DateTimeResource::make($this->created_at),
        ];
    }
}
