<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
    /**
     * 用户注册
     * @param RegisterRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(RegisterRequest $request){
        $input=$request->only(['name','email','password']);
        $user=new User();
        $user->name=$input['name'];
        $user->email=$input['email'];
        $user->password=bcrypt($input['password']);
        $user->save();
        return $this->response->created();
    }

}
