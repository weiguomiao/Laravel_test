<?php

$api = app('Dingo\Api\Routing\Router');

$middle=[
    'middleware' => [
        'api.throttle',
        'bindings',//减少 transform
        'serializer:array'
    ],
    'limit' => 100,
    'expires' => 5
];
$api->version('v1',$middle, function ($api) {

    $api->group(['prefix'=>'admin'],function ($api){

        $api->group(['middleware'=>'api.auth'],function ($api){
            //用户禁用
            $api->patch('users/{user}/lock',[\App\Http\Controllers\admin\UserController::class,'lock'])->name('users.lock');

            //展示用户
            $api->resource('users',\App\Http\Controllers\admin\UserController::class,[
                'only'=>['index','show']
            ]);

            /**
             * 分类
             */
            $api->patch('category/{category}/status',[\App\Http\Controllers\admin\CategoryController::class,'status'])->name('category.status');

            $api->resource('category',\App\Http\Controllers\admin\CategoryController::class,[
                'except'=>['destroy']
            ]);

            /**
             * 商品
             */
            $api->patch('goods/{goods}/on',[\App\Http\Controllers\admin\GoodsController::class,'isOn'])->name('goods.on');
            $api->patch('goods/{goods}/recommend',[\App\Http\Controllers\admin\GoodsController::class,'recommend'])->name('goods.recommend');
            $api->resource('goods',\App\Http\Controllers\admin\GoodsController::class,[
                'except'=>['destroy']
            ]);

            //评价管理
            $api->get('comment',[\App\Http\Controllers\Admin\CommentController::class,'index'])->name('comment.index');
            $api->get('comment/{comment}',[\App\Http\Controllers\Admin\CommentController::class,'show'])->name('comment.show');
            $api->patch('comment/{comment}/reply',[\App\Http\Controllers\Admin\CommentController::class,'reply'])->name('comment.reply');

            //订单
            $api->get('orders',[\App\Http\Controllers\Admin\OrderController::class,'index'])->name('orders.index');
            $api->get('orders/{orders}',[\App\Http\Controllers\Admin\OrderController::class,'show'])->name('orders.show');
            $api->patch('orders/{orders}/post',[\App\Http\Controllers\Admin\OrderController::class,'post'])->name('orders.post');

            //菜单
            $api->get('menu',[\App\Http\Controllers\Admin\MenuController::class,'index'])->name('menu.index');
        });
    });
});
