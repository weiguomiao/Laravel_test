<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class GoodsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'category_id'=>'required',
            'desc'=>'required|max:255',
            'price'=>'required|min:0',
            'stock'=>'required|min:0',
            'cover'=>'required',
            'pics'=>'required|array',
            'detail'=>'required',
        ];
    }
}
