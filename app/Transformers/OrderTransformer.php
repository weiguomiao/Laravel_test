<?php
/**
 * Created by : PhpStorm
 * User: weigm
 * Date: 2021/11/27 0027
 * Time: 16:19
 */

namespace App\Transformers;


use App\Models\order;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    //额外分类数据的配置
    protected $availableIncludes=['user','orderDetails'];

    public function transform(order $order)
    {
        return [
            'id' => $order->id,
            'user_id' => $order->user_id,
            'order_no' => $order->order_no,
            'amount' => $order->amount,
            'status' => $order->status,
            'address_id' => $order->address_id,
            'express_type' => $order->express_type,
            'express_no' => $order->express_no,
            'pay_time' => $order->pay_time,
            'pay_type' => $order->pay_type,
            'trade_no' => $order->trade_no,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
        ];
    }


    /**
     * 额外的用户数据
     *  @param order $order
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Order $order)
    {
        return $this->item($order->user,new UserTransformer());
    }

    public function includeOrderDetails(Order $order)
    {
        return $this->collection($order->orderDetails,new OrderDetailsTransformer());
    }
}
