<?php 
namespace Alim\LaravelSendle;

use Illuminate\Support\ServiceProvider;

class SendleServiceProvider extends ServiceProvider {
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/sandle.php','sendle');
    }

    public function boot()
    {
        $this->app->bind('sendle',function(){
            return new SendleProcessor( config('sendle',[]) );
        });

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
}