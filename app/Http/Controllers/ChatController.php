<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return TuLing::chat($message, $userID);
    }

}
