<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 16/5/7
 * Time: 19:21
 */

namespace App\Providers;


use App\Core\Services\Active;

class ActiveServiceProvider extends \HieuLe\Active\ActiveServiceProvider
{

    public function register() {
        $this->app['active'] = $this->app->share(function($app)
        {
            return new Active($app['router']);
        });
    }

}