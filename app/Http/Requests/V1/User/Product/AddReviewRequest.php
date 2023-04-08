<?php

namespace App\Http\Requests\V1\User\Product;

use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class AddReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        request()->user_phone = request()->country_code . '' . request()->phone;
        return [
            'product_id' => 'required|exists:products,id,is_active,1',
            'rate' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ];
    }
}
