<?php

namespace App\Models;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSession extends Model
{
    use SoftDeletes;
    protected $table = 'user_session';
    public $timestamps = false;
    public $guarded = [];
    public $hidden = [];
    protected $casts = ['user_id'=>'integer'];
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * 关联用户信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_info(){
        return $this->hasOne(User::class, 'id','user_id');
    }

}
