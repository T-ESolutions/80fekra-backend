<?php

namespace App\Http\Resources\V1\User\Order;

use App\Http\Resources\V1\ProductResources;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => (int)$this->id,
            'product_image' => (string)$this->product->productImages->first() ? $this->product->productImages->first()->image_path : asset('defaults/default_image.png'),
            'product_title' => (string)$this->product->title,
            'product_description' => (string)$this->product->description,
            'product_price' => (double)$this->price,
            'qty' => (int)$this->qty,
            'total' => (double)$this->total,

        ];
    }
}
