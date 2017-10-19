<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{
    protected $userID, $user, $userConfig, $weChatUserInfo;

    /**
     * BaseController constructor.
     * @param Request $request
     */
    function __construct(Request $request)
    {
        // 开启微信授权
        $isAuth = $request->has('wechatAuth') && $request->wechatAuth == 1;
        if($isAuth){
            $this->middleware('wechat.oauth:snsapi_userinfo');
        }
        $this->middleware(function ($request, $next) use($isAuth){
            $this->weChatUserInfo = session('wechat.oauth_user')['original'];
            $openID = $this->weChatUserInfo['openid'];
            $userData = [
                'openID' => $this->weChatUserInfo['openid'],
                'nickname' => $this->weChatUserInfo['nickname'],
                'avatar' => $this->weChatUserInfo['headimgurl'],
                'sex' => $this->weChatUserInfo['sex'],
                'country' => $this->weChatUserInfo['country'],
                'province' => $this->weChatUserInfo['province'],
                'city' => $this->weChatUserInfo['city'],
                'language' => $this->weChatUserInfo['language']
            ];
            $user = User::getUserByOpenID($openID);
            if($user){
                if($isAuth){
                    foreach ($userData as $key => $value){
                        $user->setAttribute($key, $value);
                    }
                    if(!$user->save()){
                        $this->error('读取用户信息出错');
                    }
                }
                $this->userConfig = UserConfig::getUserConfigByUserID($user->id);
            }else{
                DB::beginTransaction();
                $user = new User();
                if($isAuth){
                    foreach ($userData as $key => $value){
                        $user->setAttribute($key, $value);
                    }
                }
                if(!$user->save()){
                    DB::rollBack();
                    $this->error('读取用户信息出错');
                }
                $userConfig = new UserConfig();
                $userConfig->userID = $user->id;
                $defaultConfig = ['wechatAuth' => 0,'audioPlay' => 1,'person' => 0,'speed' => 5,'pitch' => 5,'volume' => 5];
                $userConfig->config = json_encode($defaultConfig);
                if(!$userConfig->save()){
                    DB::rollBack();
                    $this->error('读取用户信息出错');
                }
                DB::commit();
                $this->userConfig = $userConfig;
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
