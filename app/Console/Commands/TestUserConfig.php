<?php

namespace App\Console\Commands;

use App\Models\UserConfig;
use Illuminate\Console\Command;

class TestUserConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:user-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '测试用户配置';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $defaultConfig = ['wechatAuth' => 0,'audioPlay' => 1,'person' => 4,'speed' => 5,'pitch' => 5,'volume' => 5];
        $userConfig = UserConfig::getUserConfigByUserID(1);
        $userConfig->config = json_encode($defaultConfig);
        try{
            $userConfig->save();
            dd('保存信息成功');
        }
        catch(\Exception $e){
            dd($e->getMessage());
        }
    }
}
