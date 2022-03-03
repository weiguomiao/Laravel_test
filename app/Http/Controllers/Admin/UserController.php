<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * 用户列表
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $user = User::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%$name%");
        })->when($email, function ($query) use ($email) {
            $query->where('email', $email);
        })->paginate(3);
        return $this->response->paginator($user, new UserTransformer());
    }

    /**
     * 用户详情
     * @param User $user
     * @return \Dingo\Api\Http\Response
     */
    public function show(User $user)
    {
        //
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * 用户禁用
     * @param User $user
     * @return \Dingo\Api\Http\Response
     */
    public function lock(User $user)
    {
        $user->is_locked = $user->is_locked == 1 ? 2 : 1;
        $user->save();
        return $this->response->noContent();
    }

}
