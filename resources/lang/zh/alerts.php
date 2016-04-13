<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Alert Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain alert messages for various scenarios
    | during CRUD operations. You are free to modify these language lines
    | according to your application's requirements.
    |
    */

    'backend' => [
        'permissions' => [
            'created' => '权限创建成功.',
            'deleted' => '权限删除成功.',

            'groups'  => [
                'created' => '权限组创建成功.',
                'deleted' => '权限组删除成功.',
                'updated' => '权限组更新成功.',
            ],

            'updated' => '权限修改成功.',
        ],

        'roles' => [
            'created' => '角色创建成功.',
            'deleted' => '角色删除成功.',
            'updated' => '权限更新成功.',
        ],
        'menus' => [
            'created' => '菜单创建成功.',
            'deleted' => '菜单删除成功.',
            'updated' => '权限更新成功.',
        ],
        'users' => [
            'confirmation_email' => '已发送到您的邮箱，请到您的邮箱确认.',
            'created' => '用户创建成功.',
            'deleted' => '用户删除成功.',
            'deleted_permanently' => '永久删除这个用户.',
            'restored' => '用户恢复成功.',
            'updated' => '用户删除成功.',
            'updated_password' => "这个用户密码重置成功.",
        ]
    ],
];