<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type=$request->input('type');
        if($type=='all'){
            return cache_category_all();
        }else{
            return cache_category();
        }
    }


    /**
     * 添加分类
     * @param Request $request
     * @return array|\Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data=$this->checkInput($request);
        if(!is_array($data)) return $data;

        Category::create($data);

        return $this->response->created();
    }

    /**
     * 分类详情
     * @param Category $category
     * @return Category
     */
    public function show(Category $category)
    {
        //
        return $category;
    }

    /**
     * 更新分类数据
     * @param Request $request
     * @param Category $category
     * @return array|\Dingo\Api\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $data=$this->checkInput($request);
        if(!is_array($data)) return $data;

        $category->update($data);

        return $this->response->noContent();
    }

    /**
     * 统一校验传入值
     * @param $request
     * @return array
     */
    protected function checkInput($request){
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => '分类名称不能为空'
        ]);
        $pid = $request->input('pid', 0);
        $group = $request->input('group', 'goods');
        $level = $pid == 0 ? 1 : (Category::find($pid)->level + 1);

        if($level>3) return $this->response->errorBadRequest('不能超过三级分类哦！');

        return [
            'name' => $request->input('name'),
            'pid' => $pid,
            'level' => $level,
            'group'=>$group,
        ];
    }

    /**
     * 禁用分类
     * @param Category $category
     * @return \Dingo\Api\Http\Response
     */
    public function status(Category $category)
    {
        //
        $category->status=$category->status==1?2:1;
        $category->save();
        //清空缓存
        forget_cache_category();
        return $this->response->noContent();
    }
}
