<?php

namespace Webaccess\WCMSLaravel;

use Illuminate\Support\ServiceProvider;

use Webaccess\WCMSLaravel\Commands\CreateUserCommand;
use Webaccess\WCMSLaravel\Commands\CreateThemeCommand;
use Webaccess\WCMSLaravel\Commands\InitCommand;
use Webaccess\WCMSLaravel\Commands\PublishThemeCommand;
use Webaccess\WCMSLaravel\Commands\SelectThemeCommand;
use Webaccess\WCMSLaravel\Helpers\ShortcutHelper;


class WCMSLaravelServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include(__DIR__ . '/Http/routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'w-cms-laravel');

        $this->loadViewsFrom(__DIR__. ' /../../resources/views', 'w-cms-laravel');

        $this->publishes([
            __DIR__.'/../../resources/views/back' => base_path('resources/views/vendor/w-cms-laravel/back'),
        ], 'back_views');

        $this->publishes([
            __DIR__. '/../../config/config.php' => config_path('vendor/w-cms-laravel.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../../public/back' => base_path('/public/vendor/w-cms-laravel/back')
        ], 'back_assets');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();

        //Facades
        $this->app->bind('shortcut', function()
        {
            return new ShortcutHelper();
        });
        $loader->alias('Shortcut', 'Webaccess\WCMSLaravel\Facades\Shortcut');

        $loader->alias('Form', 'Illuminate\Html\FormFacade');
        $loader->alias('HTML', 'Illuminate\Html\HtmlFacade');

        $this->app->register('Illuminate\Html\HtmlServiceProvider');


        //Commands
        $this->app->bind('CreateUserCommand', function() {
            return new CreateUserCommand();
        });

        $this->app->bind('GenerateThemeCommand', function() {
            return new CreateThemeCommand();
        });

        $this->app->bind('PublishThemeCommand', function() {
            return new PublishThemeCommand();
        });

        $this->app->bind('InitCommand', function() {
            return new InitCommand();
        });

        $this->app->bind('SelectThemeCommand', function() {
            return new SelectThemeCommand();
        });

        $this->commands(
            array('CreateUserCommand', 'GenerateThemeCommand', 'PublishThemeCommand', 'InitCommand', 'SelectThemeCommand')
        );
    }
}
