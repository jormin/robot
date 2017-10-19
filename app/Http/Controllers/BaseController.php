<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $userID, $user, $wechatUserInfo;

    /**
     * BaseController constructor.
     * @param Request $request
     */
    function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            $this->wechatUserInfo = session('wechat.oauth_user');
            $openID = $this->wechatUserInfo['id'];
            $user = User::getUserByOpenID($openID);
            if(!$user){
                $user = new User();
                $user->openID = $openID;
                $user->save();
                $user = $user->toArray();
            }
            $this->user = $user;
            $this->userID = $user['id'];
            return $next($request);
        });
    }
}
