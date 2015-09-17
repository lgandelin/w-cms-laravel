<?php

namespace Webaccess\WCMSLaravel;

use Illuminate\Support\ServiceProvider;
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

        $this->app->bind('shortcut', function()
        {
            return new ShortcutHelper();
        });

        $loader->alias('Shortcut', 'Webaccess\WCMSLaravel\Facades\Shortcut');
        $loader->alias('Form', 'Illuminate\Html\FormFacade');
        $loader->alias('HTML', 'Illuminate\Html\HtmlFacade');

        $this->app->register('Illuminate\Html\HtmlServiceProvider');

        $this->commands([
                'Webaccess\WCMSLaravel\Commands\InitCommand',
                'Webaccess\WCMSLaravel\Commands\CreateUserCommand',
                'Webaccess\WCMSLaravel\Commands\CreateThemeCommand',
                'Webaccess\WCMSLaravel\Commands\PublishThemeCommand',
                'Webaccess\WCMSLaravel\Commands\SelectThemeCommand',
                'Webaccess\WCMSLaravel\Commands\CreateBlockTypeCommand',
            ]
        );
    }
}
