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
                if(!$user->save()){
                    $this->error('读取用户信息出错');
                }
            }
            $this->user = $user;
            $this->userID = $user['id'];
            return $next($request);
        });
    }

    /**
     * 请求错误
     *
     * @param string $msg
     */
    protected function error($msg='网络超时'){
        die(json_encode(['status'=>0, 'msg'=>$msg])) ;
    }

    /**
     * 响应信息
     *
     * @param $data
     */
    protected function response($data){
        die(json_encode($data)) ;
    }

    /**
     * 操作成功
     *
     * @param $data
     * @param string $msg
     */
    protected function success($data=null, $msg='操作成功'){
        $response = ['status'=>1, 'data'=>$data, 'msg'=>$msg];
        $this->response($response);
    }

    /**
     * 操作失败
     *
     * @param string $msg
     */
    protected function fail($msg='操作失败'){
        $response = ['status'=>0, 'msg'=>$msg];
        $this->response($response);
    }

    /**
     * 针对Service函数返回格式自动处理
     *
     * @param $return
     */
    protected function autoResult($return){
        if($return['status'] == 1){
            $this->success(array_key_exists('data', $return) ? $return['data'] : null, $return['msg']);
        }else{
            $this->fail($return['msg']);
        }
    }
}
