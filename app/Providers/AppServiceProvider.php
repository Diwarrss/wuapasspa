<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
        {
            //codigo para q me funcione guardar imagenes en el hosting
            /*$this->app->bind('path.public', function() {
                return base_path().'/../agendagrid.gridsoft.co/';
            });*/
        }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
