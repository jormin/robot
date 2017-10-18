<?php

namespace App\Http\Controllers;

use App\Models\User;

class BaseController extends Controller
{
    protected $userID, $user, $wechatUserInfo;

    /**
     * BaseController constructor.
     */
    function __construct()
    {
        $this->middleware('web');
        $this->middleware('wechat.oauth');
        $this->wechatUserInfo = session('wechat.oauth_user');
        $openID = $this->wechatUserInfo['id'];
        $user = User::getUserByOpenID($openID);
        if(!$user){
            $user = new User();
            $user->openID = $openID;
            $user->save();
        }
        $this->user = $user;
        $this->userID = $user->id;
    }
}
