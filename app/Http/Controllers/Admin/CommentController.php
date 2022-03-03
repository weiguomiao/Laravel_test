<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Comment;
use App\Models\Good;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    /**
     * 评价列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $rate = $request->input('rate');
        $goods_name = $request->input('goods_name');
        $list = Comment::when($rate, function ($query) use ($rate) {
            $query->where('rate', $rate);
        })->when($goods_name, function ($query) use ($goods_name) {
            $goods_id = Good::where('name', 'like', "%$goods_name%")->pluck('id');
            $query->whereIn('goods_id', $goods_id);
        })->paginate(5);
        return $this->response->paginator($list, new CommentTransformer());
    }


    /**
     * 评价详情
     * @param Comment $comment
     * @return \Dingo\Api\Http\Response
     */
    public function show(Comment $comment)
    {
        return $this->response->item($comment, new CommentTransformer());
    }


    /**
     * 回复评价
     * @param Request $request
     * @param Comment $comment
     * @return \Dingo\Api\Http\Response
     */
    public function reply(Request $request, Comment $comment)
    {
        //
        $request->validate([
            'reply' => 'required|max:255'
        ], [
            'reply.required' => '回复 不能为空！',
            'reply.max' => '回复 不能超过255字符！',
        ]);
        $reply = $request->input('reply');
        $comment->reply = $reply;
        $comment->save();
        return $this->response->noContent();
    }

}
