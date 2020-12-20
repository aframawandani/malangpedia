<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class Order2ProductResource extends JsonResource
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
            'order_2_product_id' => $this->order_2_product_id,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'product_url' => $this->product_url,
            'product_image' => $this->product_image,
            'product_price' => floatval($this->product_price),
            'quantity' => $this->quantity
        ];
    }
}
