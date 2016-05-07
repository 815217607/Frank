<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class UserTableSeeder
 */
class MenuTable extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }


        //Add the master administrator, user id of 1
        $menus = [
            [
                'pid'              => 0,
                'menu_name'        => '会员管理',
                'lang_key'          => 'menus.backend.access.title',
                'url' => '#',
                'rank'         => 'D',
                'permission_id'         => 2,
                'state'         => 0,
                'url_falg'         => 1,
                'lang_falg'         => 0,
                'active'         => 'admin/access/*',
                'platform'         => 1,
                'sort'         => 0,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'pid'              => 1,
                'menu_name'        => '角色管理',
                'lang_key'          => 'menus.backend.access.roles.management',
                'url' => 'admin/access/roles',
                'rank'         => 'D',
                'permission_id'         => 23,
                'state'         => 0,
                'url_falg'         => 1,
                'lang_falg'         => 1,
                'active'         => 'admin/access/roles/*',
                'platform'         => 1,
                'sort'         => 0,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],[
                'pid'              => 1,
                'menu_name'        => '会员维护',
                'lang_key'          => 'menus.backend.access.title',
                'url' => 'admin.access.users.index',
                'rank'         => 'D',
                'permission_id'         => 22,
                'state'         => 0,
                'url_falg'         => 0,
                'lang_falg'         => 0,
                'active'         => 'admin/access/users/*',
                'platform'         => 1,
                'sort'         => 0,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],[
                'pid'              => 1,
                'menu_name'        => '权限维护',
                'lang_key'          => 'menus.backend.access.permissions.management',
                'url' => 'admin.access.permissions.index',
                'rank'         => 'D',
                'permission_id'         => 25,
                'state'         => 0,
                'url_falg'         => 0,
                'lang_falg'         => 1,
                'active'         => 'admin/access/permissions*',
                'platform'         => 1,
                'sort'         => 5,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],[
                'pid'              => 1,
                'menu_name'        => '权限组维护',
                'lang_key'          => 'menus.backend.access.permissions.groups.management',
                'url' => 'admin.access.groups.permission-group.index',
                'rank'         => 'D',
                'permission_id'         => 24,
                'state'         => 0,
                'url_falg'         => 0,
                'lang_falg'         => 1,
                'active'         => 'admin/access/groups*',
                'platform'         => 1,
                'sort'         => 6,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];

        DB::table('menus')->insert($menus);

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}