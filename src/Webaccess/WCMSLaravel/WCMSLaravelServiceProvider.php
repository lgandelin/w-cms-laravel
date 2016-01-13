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
        $loader->alias('Form', 'Collective\Html\FormFacade');
        $loader->alias('HTML', 'Collective\Html\HtmlFacade');

        $this->app->register('Collective\Html\HtmlServiceProvider');

        $this->commands([
                'Webaccess\WCMSLaravel\Commands\InitCommand',
                'Webaccess\WCMSLaravel\Commands\Users\CreateUserCommand',
                'Webaccess\WCMSLaravel\Commands\BlockTypes\CreateBlockTypeCommand',
                'Webaccess\WCMSLaravel\Commands\BlockTypes\DeleteBlockTypeCommand',
                'Webaccess\WCMSLaravel\Commands\BlockTypes\ListBlockTypesCommand',
                'Webaccess\WCMSLaravel\Commands\Themes\CreateThemeCommand',
                'Webaccess\WCMSLaravel\Commands\Themes\PublishThemeCommand',
                'Webaccess\WCMSLaravel\Commands\Themes\SelectThemeCommand',
                'Webaccess\WCMSLaravel\Commands\Themes\DeleteThemeCommand',
            ]
        );
    }
}
