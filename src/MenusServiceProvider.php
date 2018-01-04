<?php
namespace JMinayaT\Menus;

use Illuminate\Support\ServiceProvider;

class MenusServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishesConfig();
        $this->registerMenuFiles();
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('menus', function($app) {
            return new MenuService();
        });
        $this->mergeConfigFrom(
            __DIR__.'/Config/menus.php',
            'menus'
        );
    }

    /**
     * publishes Config for application menus.
     *
     * @return void
     */
    protected function publishesConfig()
    {
        $this->publishes([
            __DIR__.'/Config/menus.php' => config_path('menus.php'),
            ], 'config');
    }

    /**
     * register Menu file.
     *
     */
    protected function registerMenuFiles()
    {
        if (file_exists($file = app_path('Http/Menus.php'))) {
            require $file;
        }
    }
}