<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    protected $token;

    public function token($value)
    {
        $this->token = $value;
        return $this;
    }


    public function toArray($request)
    {

        return [
            'id' => (int)$this->id,
            'f_name' => (string)$this->f_name ? $this->f_name : "",
            'l_name' => (string)$this->l_name ? $this->l_name : "",
            'email' => (string)$this->email ? $this->email : "",
            'phone' => (string)$this->phone ? $this->phone : "",
            'whats_app' => (string)$this->whats_app ? $this->whats_app : "",
            'jwt' => $this->jwt ? $this->jwt : "",
        ];
    }


}