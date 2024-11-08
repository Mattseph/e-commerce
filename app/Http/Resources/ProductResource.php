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
            'title' => $this->title,
            'description' => $this->description,
            'published' => $this->published,
            'inStock' => $this->inStock,
            'price' => $this->price,
            'brand_avg' => $this->whenAggregated('brand', 'name', 'avg'),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'brand' => BrandResource::make($this->whenLoaded('brand')),
            'created_at' => DateTimeResource::make($this->created_at),
        ];
    }
}
