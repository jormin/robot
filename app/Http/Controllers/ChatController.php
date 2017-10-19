<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use Jormin\BaiduSpeech\BaiduSpeech;
use Jormin\IP\IP;
use Jormin\TuLing\TuLing;

class ChatController extends BaseController
{

    /**
     * 聊天界面
     */
    public function index(){
        $app = new Application(config('wechat'));
        $wxJs = $app->js;
        return view('chat.index', compact('wxJs'));
    }

    /**
     * 机器人自动回复
     *
     * @param Request $request
     * @return mixed
     */
    public function robot(Request $request){
        $message = $request->message;
        $config = $request->config;
        if(!$message || !$config){
            die;
        }
        $location = implode('', IP::ip2addr($request->getClientIp()));
        $response = TuLing::chat($message, $this->userID, $location);
        if(in_array($response['code'], [100000, 200000, 302000, 308000])){
            $return = BaiduSpeech::combine($response['text'], $this->userID, 'zh', $config['speed'], $config['pitch'], $config['volume'], $config['person']);
            if($return['success'] && $config['audioPlay'] == 1){
                $response['audio'] = '/storage/'.ltrim($return['data'], 'public');
            }
        }
        return $response;
    }
}
