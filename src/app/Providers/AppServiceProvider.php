<?php

namespace App\Providers;

use App\Components\Robot;

use Laravel\Lumen\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 *
 * @property-read Application $app
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Robot::class, function () {
            return new Robot();
        });
    }
}
