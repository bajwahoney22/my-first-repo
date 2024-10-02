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
            'category' => $this->category?->name,
            'brand' => $this->brand?->name,
            'name' => $this->name,
            'price' => $this->price,
            'size' => $this->size,
            'image' => $this->thumbnail,
        ];
    }
}
