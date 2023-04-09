<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\User\UsersResources;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewsResources extends JsonResource
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
            'rate' => (int)$this->rate,
            'comment' => (string)$this->comment,
            'user' => $this->user ? new UsersResources($this->user) : '',

        ];
    }


}
