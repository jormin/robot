<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends BaseController
{

    /**
     * 保存配置
     *
     * @param Request $request
     */
    public function config(Request $request){
        $config = $request->config;
        if(!$config || !is_array($config)){
            $this->error('参数错误');
        }
        $this->user->config = json_encode($request->config);
        if($this->user->save()){
            $this->success();
        }else{
            $this->fail();
        }
    }

    /**
     *
     */
    public function index(){
        $user = session('wechat.oauth_user');
        dd($user);
        dd($this->user);
    }
}
