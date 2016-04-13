<?php

namespace App\Providers;
use App\Core\Services\TestServiceImpl;
use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
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
        $this->app->singleton('TestService', function($app) {
            return new TestServiceImpl();
        });
    }

    /**
     * @return array
     */
    public function provides() {
        return ['TestService'];
    }
}
