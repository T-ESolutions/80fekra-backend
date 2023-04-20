<?php

namespace App\Http\Resources\V1\User\Order;

use App\Http\Resources\V1\ProductResources;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $price = $this->product->price - ($this->product->price * $this->product->discount / 100);
        return [
            'id' => (int)$this->id,
            'qty' => (int)$this->qty,
            'total' => (double) $this->qty * $price,
            'product' => new ProductResources($this->product),

        ];
    }
}
