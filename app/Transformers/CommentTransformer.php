<?php
/**
 * Created by : PhpStorm
 * User: weigm
 * Date: 2021/11/27 0027
 * Time: 16:19
 */

namespace App\Transformers;


use App\Models\Category;
use App\Models\Comment;
use App\Models\Good;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    //额外分类数据的配置 可include
    protected $availableIncludes = ['goods', 'user'];

    public function transform(Comment $comment)
    {
        $pics=[];
        foreach ($comment->pics as $v){
            array_push($pics,config('conf.oss_url').$v);
        }
        return [
            'id' => $comment->id,
            'user_id' => $comment->user_id,
            'goods_id' => $comment->goods_id,
            'content' => $comment->content,
            'reply' => $comment->reply,
//            'pics' => $comment->pics,
            'pics_url' => $pics,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at,
        ];
    }

    /**
     * 额外的用户数据
     * @param Comment $comment
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Comment $comment)
    {
        return $this->item($comment->user, new UserTransformer());
    }

    /**
     * 额外 商品 请求是 加入include参数传入goods,user
     * @param Comment $comment
     * @return \League\Fractal\Resource\Item
     */
    public function includeGoods(Comment $comment)
    {
        return $this->item($comment->goods, new GoodTransformer());
    }
}
