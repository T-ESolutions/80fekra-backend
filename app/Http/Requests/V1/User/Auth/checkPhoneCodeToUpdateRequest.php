<?php

namespace App\Http\Requests\V1\User\Auth;

use Illuminate\Foundation\Http\FormRequest;

class checkPhoneCodeToUpdateRequest extends FormRequest
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
        return [
            'phone' => 'required|unique:users,phone',
            'code' => 'required|digits:4',
        ];
    }
}
