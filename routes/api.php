<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->group(['middleware'=>'api.auth'],function ($api){

    });

});
