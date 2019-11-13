<?php

namespace Flaravel\NoavUeditor;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     * @param \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $this->publishes([
            __DIR__.'/config/ueditor.php' => config_path('ueditor.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/assets/ueditor' => public_path('vendor/ueditor'),
        ], 'assets');

        $this->registerRoute($router);

        Nova::serving(function (ServingNova $event) {
            Nova::script('noav-ueditor', __DIR__.'/../dist/js/field.js');
            Nova::style('noav-ueditor', __DIR__.'/../dist/css/field.css');
            Nova::script('noav-ueditor-config',  asset('vendor/ueditor/ueditor.config.js'));
            Nova::script('noav-ueditor-all',  asset('vendor/ueditor/ueditor.all.js'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/ueditor.php', 'ueditor');
        $this->app->singleton('ueditor.storage', function ($app) {
            return new StorageManager(Storage::disk($app['config']->get('ueditor.disk', 'public')));
        });
    }


    /**
     * Register routes.
     *
     * @param $router
     */
    protected function registerRoute($router)
    {
        if (!$this->app->routesAreCached()) {
            $router->group(array_merge(['namespace' => __NAMESPACE__], config('ueditor.route.options', [])), function ($router) {
                $router->any(config('ueditor.route.name', '/ueditor/server'), 'UEditorController@serve');
            });
        }
    }
}
