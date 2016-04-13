<?php

namespace App\Providers;
use App\Core\Services\LeanCloudServiceImpl;

use Illuminate\Support\ServiceProvider;

class LeanCloudServiceProvider extends ServiceProvider
{
    public $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('LeanCloudService', function($app) {
            return new LeanCloudServiceImpl();
        });
    }

    /**
     * @return array
     */
    public function provides() {
        return ['LeanCloudService'];
    }
}
