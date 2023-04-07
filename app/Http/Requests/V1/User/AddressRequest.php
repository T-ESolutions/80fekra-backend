<?php

namespace App\Http\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'lat' => 'required|string|max:255',
            'lng' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'email' => 'required|email|max:255',
        ];
    }
}
