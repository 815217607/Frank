<?php

namespace App\Models\Access\Menu\Traits\Relationship;
use App\Models\Access\Permission\Permission;

/**
 * Class RoleRelationship
 * @package App\Models\Access\Role\Traits\Relationship
 */
trait MenuRelationship
{
    //权限数据
    public  function permissions(){
        return $this->belongsTo(Permission::class,'permission_id','id');
    }


}