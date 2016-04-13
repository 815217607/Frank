<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Strings Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in strings throughout the system.
    | Regardless where it is placed, a string can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'backend' => [
        'access' => [
            'permissions' => [
                'edit_explanation' => 'If you performed operations in the hierarchy section without refreshing this page, you will need to refresh to reflect the changes here.',

                'groups' => [
                    'hierarchy_saved' => 'Hierarchy successfully saved.',
                ],

                'sort_explanation' => 'This section allows you to organize your permissions into groups to stay organized. Regardless of the group, the permissions are still individually assigned to each role.',
            ],

            'users' => [
                'delete_user_confirm' => '你确定你想要永久删除此用户?应用程序的任何地方引用这个用户ID将最有可能的错误。继续在你的自己的风险。这个不能取消。',
                'if_confirmed_off' => '(如果证实是关闭的)',
                'restore_user_confirm' => '恢复原状的这个用户呢?',
            ],
        ],

        'dashboard' => [
            'title' => '管理平台',
            'welcome' => '欢迎光临',
        ],

        'general' => [
            'all_rights_reserved' => '保留版权所有.',
            'are_you_sure' => '你确定?',
            'boilerplate_link' => '易元科技',
            'continue' => '继续',
            'member_since' => '管理员',
            'search_placeholder' => '搜索...',

            'see_all' => [
                'messages' => '查看所有消息',
                'notifications' => '查看所有通知',
                'tasks' => '查看所有任务',
            ],

            'status' => [
                'online' => '在线',
                'offline' => '离线',
            ],

            'you_have' => [
                'messages' => '{0} 你没有信息|{1} 你有1条信息|[2,Inf] 你有 :number 条信息',
                'notifications' => '{0} 你没有通知|{1} 你有1条通知|[2,Inf] 你有 :number 条通知',
                'tasks' => '{0} 你没有任务|{1} 你有1条任务|[2,Inf] 你 :number 条任务',
            ],
        ],
    ],

    'emails' => [
        'auth' => [
            'password_reset_subject' => 'Your Password Reset Link',
            'reset_password' => 'Click here to reset your password',
        ],
    ],

    'frontend' => [
        'email' => [
            'confirm_account' => 'Click here to confirm your account:',
        ],

        'test' => 'Test',

        'tests' => [
            'based_on' => [
                'permission' => 'Permission Based - ',
                'role' => 'Role Based - ',
            ],

            'js_injected_from_controller' => 'Javascript Injected from a Controller',

            'using_blade_extensions' => 'Using Blade Extensions',

            'using_access_helper' => [
                'array_permissions' => 'Using Access Helper with Array of Permission Names or ID\'s where the user does have to possess all.',
                'array_permissions_not' => 'Using Access Helper with Array of Permission Names or ID\'s where the user does not have to possess all.',
                'array_roles' => 'Using Access Helper with Array of Role Names or ID\'s where the user does have to possess all.',
                'array_roles_not' => 'Using Access Helper with Array of Role Names or ID\'s where the user does not have to possess all.',
                'permission_id' => 'Using Access Helper with Permission ID',
                'permission_name' => 'Using Access Helper with Permission Name',
                'role_id' => 'Using Access Helper with Role ID',
                'role_name' => 'Using Access Helper with Role Name',
            ],

            'view_console_it_works' => 'View console, you should see \'it works!\' which is coming from FrontendController@index',
            'you_can_see_because' => 'You can see this because you have the role of \':role\'!',
            'you_can_see_because_permission' => 'You can see this because you have the permission of \':permission\'!',
        ],

        'user' => [
            'profile_updated' => 'Profile successfully updated.',
            'password_updated' => 'Password successfully updated.',
        ],

        'welcome_to' => '欢迎来到 :place',
    ],
];