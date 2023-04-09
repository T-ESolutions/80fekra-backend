<?php

namespace App\Http\Resources\V1\User\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'subtotal' => (double)$this->subtotal,
            'discount' => (double)$this->discount,
            'shipping_cost' => (double)$this->shipping_cost,
            'total' => (double)$this->total,
            'payment_status' => (string)$this->payment_status,
            'payment_type' => (string)$this->payment_type,
            'status' => (string)$this->status,
            'address' => $this->address,
            'coupon' => $this->coupon,
            'order_details'=> $this->whenLoaded('orderDetails')

        ];
    }
}
