<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',['middleware' => 'api.throttle', 'limit' => 100, 'expires' => 5], function ($api) {

    $api->group(['prefix'=>'auth'],function ($api){
        //注册
        $api->post('register',[\App\Http\Controllers\auth\RegisterController::class,'store']);
        //登录
        $api->post('login',[\App\Http\Controllers\auth\LoginController::class,'login']);

        $api->group(['middleware'=>'api.auth'],function ($api){
            //登出
            $api->get('logout',[\App\Http\Controllers\Auth\LoginController::class,'logout']);
            //刷新token
            $api->get('refresh',[\App\Http\Controllers\Auth\LoginController::class,'refresh']);

            //阿里用token
            $api->get('oss/token',[\App\Http\Controllers\Auth\OssController::class,'token']);
        });
    });

});
