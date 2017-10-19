## 关于Robot

`Robot` 是一个机器人自动聊天项目，采用 [图灵](http://www.tuling123.com/) 官方的Api接口，[在线体验](https://robot.lerzen.com/)，当前支持微信端语音输入。

## 安装配置

1. `clone` 代码
   
   	``` bash
   	$ git clone https://github.com/jormin/robot.git
   	```
   
2. 安装扩展
   
   	``` bash
    $ composer install
    ```
   
3. 拷贝环境变量配置文件并修改部分配置
   
   	``` bash
   	$ cd /path/to/robot
   	$ cp .env.example .env
    $ php artisan key:generate
   	```
   	
   	以下为部分配置项意义:
   	
   	App相关：
        
    | KEY  | 说明|
    | ------------ | ------------ |
    | APP_NAME | 项目名称 |
    | APP_URL | 项目URL |
    | APP_WELCOME | 欢迎语句,同时也是微信分享描述语句 |
    | APP_SHARE_ICON | 微信分享图标URL |
    
    [图灵机器人](http://www.tuling123.com/)相关：
        
    | KEY  | 说明|
    | ------------ | ------------ |
    | TULING_API_KEY | 图灵机器人ApiKey |
    
    [微信公众平台](https://mp.weixin.qq.com/)相关：
        
    | KEY  | 说明|
    | ------------ | ------------ |
    | WECHAT_APPID | 微信公众平台开发者ID |
    | WECHAT_SECRET | 微信公众平台开发者密码 |
    | WECHAT_TOKEN | 微信公众平台令牌 |
    | WECHAT_AES_KEY | 微信公众平台消息加解密密钥 |
    | WECHAT_OAUTH_SCOPES | 获取用户信息模式，默认为`snsapi_base`，仅获取openid} |
    
    [百度AI开放平台](https://cloud.baidu.com/)相关：
        
    | KEY  | 说明|
    | ------------ | ------------ |
    | BAIDU_APP_ID | 百度应用AppID |
    | BAIDU_API_KEY | 百度应用ApiKey |
    | BAIDU_SECRET_KEY | 百度应用SecretKey|
    
    [七牛云存储](https://portal.qiniu.com/)相关：
        
    | KEY  | 说明|
    | ------------ | ------------ |
    | QINIU_ACCESS_KEY | 七牛AccessKey |
    | QINIU_SECRET_KEY | 七牛SecretKey |
    | QINIU_BUCKET | 七牛存储空间名称|
    | QINIU_DOMAIN | 七牛存储空间绑定的域名|
    
    文件存储相关：
        
    | KEY  | 说明|
    | ------------ | ------------ |
    | FILESYSTEM_DRIVER | 文件默认存储驱动 |
    | FILESYSTEM_CLOUD | 文件默认云存储驱动 |

## 参考图

![](https://qiniu.blog.lerzen.com/540446d0-b24f-11e7-9d86-930ccf837dc3.jpg)
![](https://qiniu.blog.lerzen.com/589e2b90-b24f-11e7-b3ff-0fcc08389bbd.jpg)
![](https://qiniu.blog.lerzen.com/5bec6fe0-b24f-11e7-a881-f59ff47e3e41.jpg)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
