<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jormin\IP\IP;
use Jormin\TuLing\TuLing;

class ChatController extends Controller
{

    /**
     * 聊天界面
     */
    public function index(){
        $userID = str_random(16);
        return view('chat.index', compact('userID'));
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
        if(!$message || $userID){
            die;
        }
        $location = implode('', IP::ip2addr($request->getClientIp()));
        return TuLing::chat($message, $userID, $location);
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
