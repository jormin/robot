<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Overtrue\LaravelWechat\Middleware\OAuthAuthenticate;

class UserController extends BaseController
{

    /**
     * 保存配置
     *
     * @param Request $request
     */
    public function config(Request $request){
        $config = $request->all();
        if(!$config || !is_array($config)){
            $this->error('参数错误');
        }
        $this->userConfig->config = json_encode($config);
        if($this->userConfig->save()){
            $this->success();
        }else{
            $this->fail();
        }
    }

    /**
     *
     */
    public function index(){
    }
}
