<?php
/**
 * Created by : PhpStorm
 * User: weigm
 * Date: 2021/11/27 0027
 * Time: 16:19
 */

namespace App\Transformers;


use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
            'created_at'=>$user->created_at,
            'updated_at'=>$user->updated_at,
        ];
    }
}
