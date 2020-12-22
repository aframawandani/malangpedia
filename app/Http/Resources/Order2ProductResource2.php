<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order2ProductResource2 extends JsonResource
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
            'product_name' => $this->product_name,
            'product_image' => $this->product_image,
            'product_price' => is_numeric($this->product_price) ? floatval($this->product_price) : null,
            'quantity' => $this->quantity
        ];
    }
}
