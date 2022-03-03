<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;

use App\Mail\OrderPost;
use App\Models\Order;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends BaseController
{
    //订单列表
    public function index(Request $request)
    {
        $order_no = $request->input('order_no');
        $list = order::when($order_no, function ($query) use ($order_no) {
            $query->where('order_no', 'like', "%$order_no%");
        })->paginate(3);
        return $this->response->paginator($list, new OrderTransformer());
    }

    //订单详情
    public function show(Order $order)
    {
        return $this->response->item($order, new OrderTransformer());
    }

    //订单发货
    public function post(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'express_type'=>'required',
            'express_no'=>'required'
        ],[
            'express_type.required'=>'快递公司不能为空！',
            'express_no.required'=>'快递单号不能为空！',
        ]);

        //使用事件辅助函数分发
//        event(new \App\Events\OrderPost(
//            $request->input('id'),
//            $request->input('express_type'),
//            $request->input('express_no'))
//        );

        //使用事件分发
        \App\Events\OrderPost::dispatch(
            $request->input('id'),
            $request->input('express_type'),
            $request->input('express_no')
        );

//        $order=Order::find($request->input('id'));
//        $order->express_type=$request->input('express_type');
//        $order->express_no=$request->input('express_no');
//        $order->status=3;
//        $order->save();
//
//        //发送邮件
//        Mail::to($order->user)->queue(new OrderPost($order));

        return $this->response->noContent();
    }
}
