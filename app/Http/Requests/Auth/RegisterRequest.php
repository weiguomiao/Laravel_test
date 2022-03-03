<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|max:16',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|max:12'
        ];
    }

    public function messages()
    {
        return [
//            'name.required'=>'名称不能为空'
        ];
    }
}
