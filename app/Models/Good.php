<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'user_id', 'category_id', 'desc', 'price', 'stock', 'cover', 'pics', 'is_on', 'is_recommend', 'detail'
    ];

    protected $casts = [
        'pics' => 'array',
    ];

    /**
     * 商品所属的分类
     */
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    /**
     * 商品所属用户
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    //商品所有的评论
    public function comments(){
        return $this->hasMany(Comment::class,'goods_id','id');
    }
}
