<?php

namespace App\Http\Controllers\Backend\Access\Menu;

use App\Exceptions\GeneralException;
use App\Http\Requests\Backend\Access\Menu\CreateMenuRequest;
use App\Http\Requests\Backend\Access\Menu\DeleteMenuRequest;
use App\Http\Requests\Backend\Access\Menu\EditMenuRequest;
use App\Http\Requests\Backend\Access\Menu\StoreMenuRequest;
use App\Http\Requests\Backend\Access\Menu\UpdateMenuRequest;
use App\Models\Access\Menu\Menu;
use App\Models\Access\Permission\Permission;
use App\Repositories\Backend\Permission\PermissionRepositoryContract;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{

    protected $menu;

    protected $permission;
    public function __construct(Menu $menu,PermissionRepositoryContract $permission){
        $this->menu=$menu;
        $this->permission=$permission;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pre=$params=\Illuminate\Support\Facades\Request::all();
        $query=Menu::query();
        $info=$query->with('permissions')->orderBy('created_at','desc')->paginate(10);

        if(isset($pre))$info->appends($pre);
        return view('backend.access.menu.index',['menu'=>$info]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateMenuRequest $request)
    {
        $pidmenus=$this->menu->query()->where('state',0)->get();
        $permission=Permission::query()
            ->whereNotExists(function($query){
                $query->select(DB::raw(1))
                    ->from('menus')
                    ->whereRaw('menus.permission_id = permissions.id');
            })
            ->get();
        return view('backend.access.menu.create')->withPidmenus($pidmenus)->withPermissions($permission);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request)
    {
        $params= $request->all();
        $menu=new Menu();
        unset($params['_token']);
        foreach($params as $key=>$val){
            $menu->$key=$val;
        }
        $menu->save();



        return redirect()->route('admin.access.menus.index')->withFlashSuccess(trans('alerts.backend.menus.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,EditMenuRequest $request)
    {
        $info=$this->menu->query()->find($id);
        $pidmenus=$this->menu->query()->where('state',0)->get();
        $permission=Permission::query()
            ->where(function($query) use($info){
                $query->whereNotExists(function($query) {
                    $query->select(DB::raw(1))
                        ->from('menus')
                        ->whereRaw('menus.permission_id = permissions.id');
                });
                $query->orwhere('id',$info->permission_id);
            })

            ->get();


        return view('backend.access.menu.edit')->withMenu($info)->withPidmenus($pidmenus)->withPermissions($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request, $id)
    {
        $menu=Menu::query()->find($id);
        $params=$request->all();
        unset($params['_token'],$params['_method']);
        foreach($params as $key=>$val){
            if($key=='sort')
                $menu->sort = isset($input['sort']) && strlen($input['sort']) > 0 && is_numeric($input['sort']) ? (int) $input['sort'] : 0;
            else $menu->$key=$val;
        }

        $menu->save();
        return redirect()->route('admin.access.menus.index')->withFlashSuccess(trans('alerts.backend.menus.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DeleteMenuRequest $request)
    {

        $menu=$this->menu->query()->findOrFail(intval($id));
        if(!$menu)  throw new GeneralException(trans('exceptions.backend.access.menus.not_found'));
        $menu->delete();
        return redirect()->route('admin.access.menus.index')->withFlashSuccess(trans('alerts.backend.menus.deleted'));
    }


    public function menuTree(){


    }
}
