<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use Jormin\BaiduSpeech\BaiduSpeech;
use Jormin\IP\IP;
use Jormin\TuLing\TuLing;

class ChatController extends Controller
{

    /**
     * 聊天界面
     */
    public function index(){
        $userID = str_random(16);
        $app = new Application(config('wechat'));
        $wxJs = $app->js;
        return view('chat.index', compact('userID', 'wxJs'));
    }

    /**
     * 机器人自动回复
     *
     * @param Request $request
     * @return mixed
     */
    public function robot(Request $request){
        $message = $request->message;
        $userID = $request->userID;
        $config = $request->config;
        if(!$message || $userID || !$config){
            die;
        }
        $config = json_decode($config, true);
        $location = implode('', IP::ip2addr($request->getClientIp()));
        $response = TuLing::chat($message, $userID, $location);
        if(in_array($response['code'], [100000, 200000, 302000, 308000])){
            $return = BaiduSpeech::combine($response['text'], $userID, 'zh', $config['speed'], $config['pitch'], $config['volume'], $config['person']);
            if($return['success'] && $config['audioPlay'] == 'on'){
                $response['audio'] = '/storage/'.ltrim($return['data'], 'public');
            }
        }
        return $response;
    }

    /**
     * 上传文件
     *
     * @param Request $request
     * @return string
     */
    public function upfile(Request $request){
        $return = ['status'=>0, 'msg'=>'网络超时'];
        if($request->hasFile('file')){
            $path = $request->file('file')->store('audios/'.date('Ymd'));
            $return = ['status'=>1, 'msg'=>'上传成功', 'data'=>$path];
        }
        return json_encode($return);
    }

}
