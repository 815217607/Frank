<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{

    //表名
    protected $table = 'members';

    //指定主键
    protected $primaryKey = 'id';

    //指定允许批量赋值的字段
    protected $fillable = [
        'name', 'username', 'password',
    ];

    //指定不允许批量赋值的字段
    // protected $guarded = [];

//    //自动维护时间戳
//    public $timestamps = false;
//
//    //定制时间戳格式
//    protected $dateFormat = 'U';
//
//    //将默认增加时间转化为时间戳
//    protected function getDateFormat()
//    {
//        return time();
//    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'token'
    ];


    /**
     * @param $provider
     * @return bool
     */
    public function hasProvider($provider)
    {
        foreach ($this->providers as $p) {
            if ($p->provider == $provider) {
                return true;
            }

        }

        return false;
    }
}
