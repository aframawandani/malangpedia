<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_id' => $this->product_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => floatval($this->price),
            'quantity' => $this->quantity,
            'sold' => floatval($this->sold),
            'url' => $this->url,
            'image' => $this->image,
            'rating' => is_numeric($this->rating) ? floatval($this->rating) : null,
            'categories' => $this->categories,
            'galleries' => $this->galleries
        ];
    }
}
