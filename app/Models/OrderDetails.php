<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    //详情所属订单
    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function goods(){
        return $this->hasOne(Good::class,'id','goods_id');
    }
}
