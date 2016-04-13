<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Menus Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in menu items throughout the system.
    | Regardless where it is placed, a menu item can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'backend' => [
        'access' => [
            'title' => '会员管理',

            'permissions' => [
                'all' => '所有权限',
                'create' => '创建权限',
                'edit' => '编辑权限',
                'groups' => [
                    'all' => '所有组',
                    'create' => '创建组',
                    'edit' => '编辑组',
                    'main' => '组',
                    'management' => '组管理',
                ],
                'main' => '权限',
                'management' => '权限管理',
            ],

            'roles' => [
                'all' => '所有角色',
                'create' => '创建角色',
                'edit' => '编辑角色',
                'management' => '角色管理',
                'main' => '角色',
            ],

            'users' => [
                'all' => '更多用户',
                'change-password' => '更改密码',
                'create' => '创建用户',
                'deactivated' => '无效用户',
                'deleted' => '删除用户',
                'edit' => '编辑用户',
                'main' => '用户',
            ],
            'menus' => [
                'all' => '所有菜单',
                'management' => '菜单管理',
                'create' => '创建菜单',
                'edit' => '编辑菜单',
                'main' => '菜单',
            ],
        ],

        'log-viewer' => [
            'main' => '查看日志',
            'dashboard' => '管理',
            'logs' => '日志',
        ],

        'sidebar' => [
            'dashboard' => '首页',
            'general' => '菜单',
        ],
    ],

    'language-picker' => [
        'language' => '语言',
        /**
         * Add the new language to this array.
         * The key should have the same language code as the folder name.
         * The string should be: 'Language-name-in-your-own-language (Language-name-in-English)'.
         * Be sure to add the new language in alphabetical order.
         */
        'langs' => [
            'da' => '丹麦语',
            'de' => '德语',
            'en' => '英语',
            'es' => '西班牙语',
            'fr' => '法语',
            'it' => '意大利语',
            'pt-BR' => '巴西(葡萄牙语)',
            'sv' => '瑞典语',
            'zh' => '中国(简体)',
        ],
    ],
];
