<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Labels Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in labels throughout the system.
    | Regardless where it is placed, a label can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'general' => [
        'all' => 'All',
        'yes' => '是',
        'no' => '否',
        'custom' => '自定义',
        'actions' => '操作',
        'buttons' => [
            'save' => '保存',
            'update' => '更新',
        ],
        'hide' => '隐藏',
        'none' => '无',
        'show' => '详情',
        'toggle_navigation' => '切换导航',
    ],

    'backend' => [
        'access' => [
            'permissions' => [
                'create' => '创建权限',
                'dependencies' => '依赖权限',
                'edit' => '编辑权限',

                'groups' => [
                    'create' => '创建组',
                    'edit' => '编辑',

                    'table' => [
                        'name' => '名称',
                    ],
                ],

                'grouped_permissions' => '权限组',
                'label' => '权限',
                'management' => '权限管理',
                'no_groups' => '这儿没有权限组.',
                'no_permissions' => '没有选择权限',
                'no_roles' => '没设置角色',
                'no_ungrouped' => '没有未分组的权限.',

                'table' => [
                    'dependencies' => '管理',
                    'group' => '组',
                    'group-sort' => '排序',
                    'name' => '名字',
                    'permission' => '权限',
                    'roles' => '角色',
                    'system' => '体系',
                    'total' => '总权限|权限总数',
                    'users' => '用户组',
                ],

                'tabs' => [
                    'general' => '大概',
                    'groups' => '所有组',
                    'dependencies' => '依赖关系',
                    'permissions' => '所有权限',
                ],

                'ungrouped_permissions' => '未分组的权限',
            ],

            'roles' => [
                'create' => '创建角色',
                'edit' => '编辑角色',
                'management' => '角色管理',

                'table' => [
                    'number_of_users' => '用户数',
                    'permissions' => '权限',
                    'role' => '角色',
                    'sort' => '排序',
                    'total' => '角色总|总角色',
                ],
            ],

            'users' => [
                'active' => '活跃用户',
                'all_permissions' => '所有权限',
                'change_password' => '更改密码',
                'change_password_for' => '修改:user密码 ',
                'create' => '创建用户',
                'deactivated' => '停用用户',
                'deleted' => '删除用户',
                'dependencies' => '依赖',
                'edit' => '编辑用户',
                'management' => '用户管理',
                'no_other_permissions' => '无任何权限',
                'no_permissions' => '没权限',
                'no_roles' => '没权限设置.',
                'permissions' => '权限',
                'permission_check' => '检查所有用户的权限依赖关系.',

                'table' => [
                    'confirmed' => '确认',
                    'created' => '创建',
                    'email' => '邮箱',
                    'id' => 'ID',
                    'last_updated' => '最后更新',
                    'name' => '名称',
                    'no_deactivated' => '没有停用的用户',
                    'no_deleted' => '没有删除的用户',
                    'other_permissions' => '其他权限',
                    'roles' => '角色',
                    'total' => '总用户数|用户总数',
                ],
            ],


            'menus' => [
                'active' => '活跃菜单',
                'create' => '创建菜单',

                'deleted' => '删除菜单',
                'dependencies' => '依赖',
                'edit' => '编辑菜单',
                'management' => '菜单管理',
                'permissions' => '权限',

                'table' => [
                    'confirmed' => '确认',
                    'created' => '创建',
                    'email' => '邮箱',
                    'id' => 'ID',
                    'pid' => '父级菜单ID',
                    'pid_name' => '父级菜单',
                    'menu_name' => '菜单名称',
                    'lang_key' => '国际化key',
                    'url' => '路由地址',
                    'rank' => '权限级别',
                    'permission_id' => '权限ID',
                    'permission_name' => '权限名称',
                    'grade' => '权限级别',
                    'platform' => '平台',
                    'sort' => '序号',
                    'last_updated' => '最后更新',
                    'created_at' => '创建时间',
                    'updated_at' => '更新时间',
                    'name' => '名称',
                    'roles' => '角色',
                    'total' => '总菜单数|菜单总数',
                ],
            ],
        ],
    ],

    'frontend' => [

        'auth' => [
            'login_box_title' => '登录',
            'login_button' => '登录',
            'login_with' => '登录方式 :social_media',
            'register_box_title' => '注册',
            'register_button' => '注册',
            'remember_me' => '永久有效',
        ],

        'passwords' => [
            'forgot_password' => '忘记密码?',
            'reset_password_box_title' => '重置密码',
            'reset_password_button' => '重置密码',
            'send_password_reset_link_button' => '修改密码',
        ],

        'macros' => [
            'country' => [
                'alpha' => 'Country Alpha Codes',
                'alpha2' => 'Country Alpha 2 Codes',
                'alpha3' => 'Country Alpha 3 Codes',
                'numeric' => 'Country Numeric Codes',
            ],

            'macro_examples' => 'Macro Examples',

            'state' => [
                'mexico' => 'Mexico State List',
                'us' => [
                    'us' => 'US States',
                    'outlying' => 'US Outlying Territories',
                    'armed' => 'US Armed Forces',
                ],
            ],

            'territories' => [
                'canada' => 'Canada Province & Territories List',
            ],

            'timezone' => '时区',
        ],

        'user' => [
            'passwords' => [
                'change' => '重置密码',
            ],

            'profile' => [
                'avatar' => '头像',
                'created_at' => '创建时间',
                'edit_information' => '编辑用户名',
                'email' => 'E-mail',
                'last_updated' => '修改时间',
                'name' => '用户名',
                'update_information' => '更新信息',
            ],
        ],

    ],
];
