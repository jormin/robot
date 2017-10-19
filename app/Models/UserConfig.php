<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserConfig
 *
 * @mixin \Eloquent
 */
class UserConfig extends Model
{

    /**
     * 根据用户ID查询配置
     *
     * @param $userID
     * @return Model|null|static
     */
    public static function getUserConfigByUserID($userID){
        $userConfig = self::query()->where('userID', $userID)->first();
        return $userConfig;
    }
}
