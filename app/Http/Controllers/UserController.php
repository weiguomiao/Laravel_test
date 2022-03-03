<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    //
    public function userList(Request $request)
    {
        dd(bcrypt('123456'));
        $users = User::paginate(3);

        return $this->response->paginator($users, new UserTransformer)
            ->withHeader('X-Foo', 'Bar');
    }

    public function name()
    {
        $url = app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('users.index');
        dd($url);
    }

    public function users()
    {
//        $user = User::all();
//        return $this->response->collection($user, new UserTransformer);

//        $user = app('Dingo\Api\Auth\Auth')->user();
//        return $user;

        $user=auth('api')->user();
        return $user;
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return $this->response->errorUnauthorized();
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
