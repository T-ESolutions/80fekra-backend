<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryCustomResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    private static $request;

    public function toArray($request)
    {
        $selected = 0;
        if (isset($request['category_id'])) {
            if ($request['category_id'] == $this->id) {
                $selected = 1;
            } else {
                $selected = 0;
            }
        }
        return [
            'id' => (int)$this->id,
            'image' => (string)$this->image ? $this->image_path : "",
            'title' => (string)$this->title,
            'selected' => $selected,
        ];
    }

    public static function customCollection($resource, $request)
    {

        //you can add as many params as you want.
        self::$request = $request;
        return parent::collection($resource);
    }


}
