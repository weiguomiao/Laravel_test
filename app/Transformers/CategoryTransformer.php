<?php
/**
 * Created by : PhpStorm
 * User: weigm
 * Date: 2021/11/27 0027
 * Time: 16:19
 */

namespace App\Transformers;


use App\Models\Category;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [
            'id'=>$category->id,
            'name'=>$category->name,
        ];
    }
}
