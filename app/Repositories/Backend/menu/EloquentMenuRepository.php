<?php

namespace App\Repositories\Backend\Menu;


use App\Exceptions\GeneralException;
use App\Models\Access\Menu\Menu;

/**
 * Class EloquentMenuRepository
 * @package App\Repositories\Menu
 */
class EloquentMenuRepository implements MenuContract
{
    /**
     * @var RoleRepositoryContract
     */
//    protected $role;

    /**
     * @var FrontendMenuContract
     */
    protected $menu;

    /**
     * @param RoleRepositoryContract $role
     * @param FrontendMenuContract $menu
     */
    public function __construct(
//        RoleRepositoryContract $role,
         Menu $menu
    )
    {
//        $this->role = $role;
        $this->menu = $menu;
    }

    /**
     * @param  $id
     * @param  bool               $withRoles
     * @throws GeneralException
     * @return mixed
     */
    public function findOrThrowException($id, $withRoles = false)
    {
        if ($withRoles) {
            $menu = Menu::with('permissions')->withTrashed()->find($id);
        } else {
            $menu = Menu::withTrashed()->find($id);
        }

        if (!is_null($menu)) {
            return $menu;
        }

        throw new GeneralException(trans('exceptions.backend.access.menus.not_found'));
    }

    /**
     * @param  $per_page
     * @param  string      $order_by
     * @param  string      $sort
     * @param  int         $status
     * @return mixed
     */
    public function getMenusPaginated($per_page, $status = 1, $order_by = 'id', $sort = 'asc')
    {
        return Menu::query()->with('permissions')
            ->orderBy($order_by, $sort)
            ->paginate($per_page);
    }

    /**
     * @param  $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedMenusPaginated($per_page)
    {
        return Menu::onlyTrashed()
            ->paginate($per_page);
    }

    /**
     * @param  string  $order_by
     * @param  string  $sort
     * @return mixed
     */
    public function getAllMenus($order_by = 'id', $sort = 'asc')
    {
        return Menu::query()->orderBy($order_by, $sort)
            ->get();
    }

    /**
     * @param  $input
     * @param  $roles
     * @param  $permissions
     * @throws GeneralException
     * @throws MenuNeedsRolesException
     * @return bool
     */
    public function create($input, $roles, $permissions)
    {
        $menu = $this->createMneuStub($input);

        if ($menu->save()) {

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
    }

    /**
     * @param $id
     * @param $input
     * @param $roles
     * @param $permissions
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input, $roles, $permissions)
    {
        $menu = $this->findOrThrowException($id);
        $this->checkUrl($input, $menu);

        if ($menu->update($input)) {
            //For whatever reason this just wont work in the above call, so a second is needed for now
//            $menu->status    = isset($input['status']) ? 1 : 0;
//            $menu->confirmed = isset($input['confirmed']) ? 1 : 0;
            $menu->save();

            $this->checkMenuRolesCount($roles);
//            $this->flushRoles($roles, $menu);
//            $this->flushPermissions($permissions, $menu);

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.update_error'));
    }

    /**
     * @param  $id
     * @param  $input
     * @throws GeneralException
     * @return bool
     */
    public function updatePassword($id, $input)
    {
        $menu = $this->findOrThrowException($id);

        //Passwords are hashed on the model
        $menu->password = $input['password'];
        if ($menu->save()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.update_password_error'));
    }

    /**
     * @param  $id
     * @throws GeneralException
     * @return bool
     */
    public function destroy($id)
    {



        $menu = $this->findOrThrowException($id);
        if ($menu->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.delete_error'));
    }

    /**
     * @param  $id
     * @throws GeneralException
     * @return boolean|null
     */
    public function delete($id)
    {
        $menu = $this->findOrThrowException($id, true);

        //Detach all roles & permissions
        $menu->detachRoles($menu->roles);
        $menu->detachPermissions($menu->permissions);

        try {
            $menu->forceDelete();
        } catch (\Exception $e) {
            throw new GeneralException($e->getMessage());
        }
    }

    /**
     * @param  $id
     * @throws GeneralException
     * @return bool
     */
    public function restore($id)
    {
        $menu = $this->findOrThrowException($id);

        if ($menu->restore()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.restore_error'));
    }

    /**
     * @param  $id
     * @param  $status
     * @throws GeneralException
     * @return bool
     */
    public function mark($id, $status)
    {
        if (access()->id() == $id && $status == 0) {
            throw new GeneralException(trans('exceptions.backend.access.users.cant_deactivate_self'));
        }

        $menu         = $this->findOrThrowException($id);
        $menu->status = $status;

        if ($menu->save()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.mark_error'));
    }

    /**
     * Check to make sure at lease one role is being applied or deactivate user
     *
     * @param  $menu
     * @param  $roles
     * @throws MenuNeedsRolesException
     */
    private function validateRoleAmount($menu, $roles)
    {
        //Validate that there's at least one role chosen, placing this here so
        //at lease the user can be updated first, if this fails the roles will be
        //kept the same as before the user was updated
        if (count($roles) == 0) {
            //Deactivate user
            $menu->status = 0;
            $menu->save();

            $exception = new MenuNeedsRolesException();
            $exception->setValidationErrors(trans('exceptions.backend.access.users.role_needed_create'));

            //Grab the user id in the controller
            $exception->setMenuID($menu->id);
            throw $exception;
        }
    }

    /**
     * @param  $input
     * @param  $menu
     * @throws GeneralException
     */
    private function checkUrl($input, $menu)
    {
        //Figure out if email is not the same
        if ($menu->url != $input['url']) {
            //Check to see if email exists
            if (Menu::where('url', '=', $input['url'])->first()) {
                throw new GeneralException(trans('exceptions.backend.access.users.email_error'));
            }

        }
    }

    /**
     * @param $roles
     * @param $menu
     */
    private function flushRoles($roles, $menu)
    {
        //Flush roles out, then add array of new ones
        $menu->detachRoles($menu->roles);
        $menu->attachRoles($roles['assignees_roles']);
    }

    /**
     * @param $permissions
     * @param $menu
     */
    private function flushPermissions($permissions, $menu)
    {
        //Flush permissions out, then add array of new ones if any
        $menu->detachPermissions($menu->permissions);
        if (count($permissions['permission_user']) > 0) {
            $menu->attachPermissions($permissions['permission_user']);
        }

    }

    /**
     * @param  $roles
     * @throws GeneralException
     */
    private function checkMenuRolesCount($roles)
    {
        //Menu Updated, Update Roles
        //Validate that there's at least one role chosen
        if (count($roles['assignees_roles']) == 0) {
            throw new GeneralException(trans('exceptions.backend.access.users.role_needed'));
        }

    }

    /**
     * @param  $input
     * @return mixed
     */
    private function createMneuStub($input)
    {
        $menu                       = new Menu();
        $menu->pid                  = $input['pid'];
        $menu->menu_name            = $input['menu_name'];
        $menu->lang_key             = isset($input['lang_key'])?$input['lang_key']:'';
        $menu->url                  = isset($input['url']) ? $input['url'] : '';
        $menu->rank                 = isset($input['rank']) ? $input['rank']:'';
        $menu->permission_id        = isset($input['permission_id']) ? $input['permission_id'] : 0;
        $menu->grade                = isset($input['grade']) ? $input['grade']:'';
        $menu->platform             = isset($input['platform']) ? $input['platform']:'';
        $menu->sort                 = isset($input['sort']) ? $input['sort']:0;
        return $menu;
    }
}
