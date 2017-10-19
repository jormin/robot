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
        $config = $request->all();
        if(!$config || !is_array($config)){
            $this->error('参数错误');
        }
        $auth = (json_decode($this->userConfig->config, true)['wechatAuth'] == 0) && ($config['wechatAuth'] == 1) ? 1 : 0;
        $this->userConfig->config = json_encode($config);
        if($this->userConfig->save()){
            $this->success(['auth'=>$auth]);
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
