<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResources extends JsonResource
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
            'key' => (string)$this->key ,
            'value' => (string)$this->value ? $this->value : '' ,
            'image' => (string)$this->image ? $this->image_path : "",
        ];
    }


}
