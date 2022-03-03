<?php
/**
 * Created by : PhpStorm
 * User: weigm
 * Date: 2021/11/27 0027
 * Time: 16:19
 */

namespace App\Transformers;


use App\Models\Category;
use App\Models\Good;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class GoodTransformer extends TransformerAbstract
{
    //额外分类数据的配置
    protected $availableIncludes=['category','user','comments'];

    public function transform(Good $good)
    {
        $pics=[];
        foreach ($good->pics as $v){
            array_push($pics,config('conf.oss_url').$v);
        }
        return [
            'id' => $good->id,
            'name' => $good->name,
            'category_id' => $good->category_id,
//            'category_name' => Category::find($good->category_id)['name'],
            'desc' => $good->desc,
            'price' => $good->price,
            'stock' => $good->stock,
            'cover' => $good->cover,
            'cover_url' => config('conf.oss_url').$good->cover,
//            'pics' => $good->pics,
            'pics_url' => $pics,
            'detail' => $good->detail,
            'is_no' => $good->is_no,
            'is_recommend' => $good->is_recommend,
            'created_at' => $good->created_at,
            'updated_at' => $good->updated_at,
        ];
    }

    /**
     * 额外的分类数据
     * @param Good $good
     * @return \League\Fractal\Resource\Item
     */
    public function includeCategory(Good $good)
    {
        return $this->item($good->category,new CategoryTransformer());
    }

    /**
     * 额外的用户数据
     *  @param Good $good
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Good $good)
    {
        return $this->item($good->user,new UserTransformer());
    }

    public function includeComments(Good $good)
    {
        return $this->collection($good->comments,new CommentTransformer());
    }
}
