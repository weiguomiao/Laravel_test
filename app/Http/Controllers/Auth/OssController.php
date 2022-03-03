<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class OssController extends BaseController
{
    /**
     * 获取oss上传的token
     */
    public function token(){
        $disk = Storage::disk('oss');
        $config = $disk->signatureConfig($prefix = '/', $callBackUrl = '', $customData = [], $expire = 3000);
        $config_arr=json_decode($config,true);
        return $this->response->array($config_arr);
    }
}
