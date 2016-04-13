<?php

namespace App\Models\Access\Menu;

use App\Models\Access\Menu\Traits\Attribute\MenuAttribute;
use App\Models\Access\Menu\Traits\Relationship\MenuRelationship;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use MenuRelationship, MenuAttribute;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     *
     */
    public function __construct()
    {
        $this->table = config('access.menus_table');
    }

//    public function childrens(){
//        return $this->hasMany(Menu::class,'pid','id');
//    }

}
