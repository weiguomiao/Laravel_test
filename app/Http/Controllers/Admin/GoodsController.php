<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GoodsRequest;
use App\Models\Category;
use App\Models\Good;
use App\Transformers\GoodTransformer;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{
    /**
     * 商品列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $category_id = $request->input('category_id');
        $is_no = $request->input('is_no', false);
        $is_recommend = $request->input('is_recommend', false);
        $goods = Good::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%$name%");
        })->when($category_id, function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->when($is_no !== false, function ($query) use ($is_no) {
            $query->where('is_no', $is_no);
        })->when($is_recommend !== false, function ($query) use ($is_recommend) {
            $query->where('is_recommend', $is_recommend);
        })->paginate(1);
        return $this->response->paginator($goods, new GoodTransformer());
    }

    /**
     * 添加商品
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(GoodsRequest $request)
    {
        $category = Category::find($request->category_id);
        if (!$category) $this->response->errorBadRequest('该分类不存在');
        if ($category->status == 2) $this->response->errorBadRequest('该分类被禁用');
        if ($category->level != 3) $this->response->errorBadRequest('只能向三级分类添加商品');

        $user_id = auth('api')->id();
        $request->offsetSet('user_id', $user_id);
        Good::create($request->all());
        return $this->response->created();
    }

    /**
     * 商品详情
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Good $good)
    {
        //
        return $this->response->item($good, new GoodTransformer());
    }

    /**
     * 修改商品
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(GoodsRequest $request, Good $good)
    {
        //
        $category = Category::find($request->category_id);
        if (!$category) $this->response->errorBadRequest('该分类不存在');
        if ($category->status == 2) $this->response->errorBadRequest('该分类被禁用');
        if ($category->level != 3) $this->response->errorBadRequest('只能向三级分类添加商品');

        $user_id = auth('api')->id();
        $request->offsetSet('user_id', $user_id);
        Good::update($request->all());
        return $this->response->noContent();
    }

    /**
     * 是否上架
     * @param Good $good
     * @return \Dingo\Api\Http\Response
     */
    public function isOn(Good $good)
    {
        $good->is_no = $good->is_no == 1 ? 2 : 1;
        $good->save();
        return $this->response->noContent();
    }

    /**
     * 是否推荐
     * @param Good $good
     * @return \Dingo\Api\Http\Response
     */
    public function isRecommend(Good $good)
    {
        $good->is_recommend = $good->is_recommend == 1 ? 2 : 1;
        $good->save();
        return $this->response->noContent();
    }
}
