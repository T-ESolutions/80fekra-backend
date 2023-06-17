<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressesResources extends JsonResource
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
            'address' => (string)$this->address,
            'f_name' => (string)$this->f_name,
            'l_name' => (string)$this->l_name,
            'phone' => (string)$this->phone,
            'country_id' => (int)$this->country_id,
            'country_shipping_cost' => $this->country ? (int)$this->country->shipping_cost : 0,
            'country_title' => $this->country ? (string)$this->country->title : '',
            'city_id' => (int)$this->city_id,
            'city_title' => $this->city ? (string)$this->city->title : '',
            'city_shipping_cost' => $this->city ? (double)$this->city->shipping_cost : 0.0,
            'is_default' => (int)$this->is_default,
        ];
    }


}
