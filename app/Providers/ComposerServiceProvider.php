<?php

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 使用类来指定视图组件
//        View::composer(['home.partials.banner'], 'App\Http\Controllers\ViewComposers\BannerComposer');
//        View::composer([
//            'home.partials.footer',
//            'users.partials.footer',
//            'home.help_show',
//        ],
//            'App\Http\Controllers\ViewComposers\FootComposer');
//        View::composer([
//            'home.partials.footer',
//            'users.partials.footer'
//        ],
//            'App\Http\Controllers\ViewComposers\LinkComposer');
//        //用户信息
//        View::composer([
//            'widget.user.profile'
//        ],
//            'App\Http\Controllers\ViewComposers\ProfileComposer');

//        View::composers([
//            'App\Http\ViewComposers\ProfileComposer' => ['home.partials.banner'],
//        ]);

        // 使用闭包来指定视图组件
//        view()->composer(
//            'home.partials.banner', 'App\Http\Controllers\ViewComposers\ProfileComposer'
//        );

        // 使用闭包来指定菜单组件
        view()->composer(
            'backend.includes.sidebar', 'App\Http\Controllers\ViewComposers\MenuComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

}
