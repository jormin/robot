<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 根据OPENID查询用户
     *
     * @param $openID
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public static function getUserByOpenID($openID){
        $user = self::query()->where('openID', $openID)->first();
        return $user;
    }
}
