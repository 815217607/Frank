<?php

namespace App\Models;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $table = 'user_session';
    public $timestamps = false;
    public $guarded = [];
    public $hidden = [];
    protected $casts = ['user_id'=>'integer'];

    /**
     * 关联用户信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_info(){
        return $this->hasOne(User::class, 'id','user_id');
    }
}
