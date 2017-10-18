<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class WechatController
 * @package App\Http\Controllers
 */
class WeChatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve(Request $request)
    {
        if($request->isMethod('get')){
            die($request->echoStr);
        }
    }
}
