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
     */
    public function config(Request $request){
        $config = $request->config;
        if(!$config){
            die;
        }
    }

    /**
     *
     */
    public function index(){
        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        dd($user);
    }
}
