<?php

namespace App\Http\Controllers\ViewComposers;



use App\Models\Access\Menu\Menu;
use App\Models\Access\Permission\Permission;
use App\Models\Access\User\User;
use HieuLe\Active\Facades\Active;
use Illuminate\Contracts\View\View;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class MenuComposer
{
    /**
     * The user repository implementation.
     *
     * @var BannerRepository
     */
    protected $menu;

    protected $lang_falg=false;

    protected $url_falg=false;

    protected $menu_view='';
    /**
     * Create a new profile composer.
     *
     * @param  BannerRepository  $users
     * @return void
     */
    public function __construct()
    {


        // service container 会自动解析所需的参数
//        $this->menu =$menu->query()->where('state',0)->get();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

//        $info=Auth::user()->roles;
//        dump($info);die;
        $user=Auth::user();
        $psers=[];
        if($user){
            $permissions=[];
            $roles=[];
        foreach($user->roles as $val){
            if(isset($val->permissions))
            {
                foreach($val->permissions as $v){
                    $permissions[]=$v->id;
                }
            }
            if(isset($val['pivot'])){
                $roles[]=$val->pivot->role_id;
            }
        }
            $psers= Permission::query()->where(function($query)use($permissions,$roles){
                if(!access()->allow('user-view-management')){
                    $query->whereExists(function($query) use($roles){
                        $query->select(DB::raw(1))
                            ->from('permission_role')
                            ->whereRaw('permission_role.permission_id = permissions.id');
                        $query->whereIn('role_id',$roles);
                    });
                    $query->OrwhereIn('permissions.id',$permissions);
                }

            })->join('menus','menus.permission_id','=','permissions.id')->orderBy('menus.sort','desc')->get(['menus.*','permissions.name as permission_name'])->toArray();

        }
        $data=$this->arrayToTree($psers,'id','pid','children');
        return $view->with('menu_info',$data);
    }

    protected function children(){
        if(!$this->menu) return false;
        $data=$this->menu->toArray();

        $data=$this->arrayToTree($data,'id','pid','children');

       return $data;

    }

    protected function arrayToTree($sourceArr, $key='id', $parentKey='pid', $childrenKey='children')
    {
        $tempSrcArr = array();

        $allRoot = TRUE;
        foreach ($sourceArr as  $v)
        {
            $isLeaf = TRUE;
            foreach ($sourceArr as $cv )
            {
                if (($v[$key]) != $cv[$key])
                {
                    if ($v[$key] == $cv[$parentKey])
                    {
                        $isLeaf = FALSE;
                    }
                    if ($v[$parentKey] == $cv[$key])
                    {
                        $allRoot = FALSE;
                    }
                }
            }
            if ($isLeaf)
            {
                $leafArr[$v[$key]] = $v;
            }
            $tempSrcArr[$v[$key]] = $v;
//            $tempSrcArr[$v[$key]][$childrenKey] = false;
        }
        if ($allRoot)
        {
            return $tempSrcArr;
        }
        else
        {
            unset($v, $cv, $sourceArr, $isLeaf);
            foreach ($leafArr as  $v)
            {
                if (isset($tempSrcArr[$v[$parentKey]]))
                {
                    $tempSrcArr[$v[$parentKey]][$childrenKey] = (isset($tempSrcArr[$v[$parentKey]][$childrenKey]) && is_array($tempSrcArr[$v[$parentKey]][$childrenKey])) ? $tempSrcArr[$v[$parentKey]][$childrenKey] : array();
                    array_push ($tempSrcArr[$v[$parentKey]][$childrenKey], $v);
                    unset($tempSrcArr[$v[$key]]);
                }
            }
            unset($v);
            return $this->arrayToTree($tempSrcArr, $key, $parentKey, $childrenKey);
        }
    }

}
