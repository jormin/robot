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
        if(!$config){
            die;
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
