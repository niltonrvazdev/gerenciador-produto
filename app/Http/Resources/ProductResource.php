<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => $this->image_url, // Adicionado
            'price' => (float) $this->price,
            'stock' => (int) $this->stock,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
