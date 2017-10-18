<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use Jormin\BaiduSpeech\BaiduSpeech;
use Jormin\IP\IP;
use Jormin\TuLing\TuLing;

class UserController extends Controller
{

    /**
     * 保存配置
     *
     * @param Request $request
     * @return mixed
     */
    public function config(Request $request){
        $config = $request->config;
        if(!$config){
            die;
        }
        return $response;
    }
}
