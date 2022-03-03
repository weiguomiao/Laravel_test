<?php
/**
 * Created by : PhpStorm
 * User: weigm
 * Date: 2021/11/27 0027
 * Time: 16:19
 */

namespace App\Transformers;


use App\Models\orderDetails;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class OrderDetailsTransformer extends TransformerAbstract
{
    protected $availableIncludes=['order','goods'];

    public function transform(OrderDetails $orderDetails)
    {
        return [
            'id'=>$orderDetails->id,
            'order_id'=>$orderDetails->order_id,
            'goods_id'=>$orderDetails->goods_id,
            'price'=>$orderDetails->price,
            'num'=>$orderDetails->num,
            'created_at'=>$orderDetails->created_at,
            'updated_at'=>$orderDetails->updated_at,
        ];
    }

    public function IncludeOrder(OrderDetails $orderDetails){
        return $this->item($orderDetails->order,new OrderTransformer());
    }

    public function IncludeGoods(OrderDetails $orderDetails){
        return $this->item($orderDetails->goods,new GoodTransformer());
    }
}
