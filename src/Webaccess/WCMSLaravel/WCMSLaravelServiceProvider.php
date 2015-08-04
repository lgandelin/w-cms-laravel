<?php

namespace Webaccess\WCMSLaravel;

use CMS\Context;
use CMS\Events\Events;
use Illuminate\Support\ServiceProvider;

use Webaccess\WCMSLaravel\Commands\CreateUserCommand;
use Webaccess\WCMSLaravel\Commands\CreateThemeCommand;
use Webaccess\WCMSLaravel\Helpers\ShortcutHelper;
use Webaccess\WCMSLaravel\Repositories\Blocks\EloquentBlockArticleListRepository;
use Webaccess\WCMSLaravel\Repositories\Blocks\EloquentBlockArticleRepository;
use Webaccess\WCMSLaravel\Repositories\Blocks\EloquentBlockHTMLRepository;
use Webaccess\WCMSLaravel\Repositories\Blocks\EloquentBlockMediaRepository;
use Webaccess\WCMSLaravel\Repositories\Blocks\EloquentBlockMenuRepository;
use Webaccess\WCMSLaravel\Repositories\Blocks\EloquentBlockViewRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentAreaRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentArticleCategoryRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentArticleRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentBlockRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentBlockTypeRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentLangRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentMediaFormatRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentMediaRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentMenuItemRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentMenuRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentPageRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentUserRepository;

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
            __DIR__.'/../../database/' => base_path('/database')
        ], 'database');

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

        $this->commands(
            array('CreateUserCommand', 'GenerateThemeCommand')
        );

        //Init Context
        Context::add('page', new EloquentPageRepository());
        Context::add('area', new EloquentAreaRepository());
        Context::add('lang', new EloquentLangRepository());
        Context::add('block', new EloquentBlockRepository());
        Context::add('menu', new EloquentMenuRepository());
        Context::add('menu_item', new EloquentMenuItemRepository());
        Context::add('article', new EloquentArticleRepository());
        Context::add('article_category', new EloquentArticleCategoryRepository());
        Context::add('media', new EloquentMediaRepository());
        Context::add('media_format', new EloquentMediaFormatRepository());
        Context::add('user', new EloquentUserRepository());
        Context::add('block_type', new EloquentBlockTypeRepository());

        Context::add('block_html', new EloquentBlockHTMLRepository());
        Context::add('block_menu', new EloquentBlockMenuRepository());
        Context::add('block_article', new EloquentBlockArticleRepository());
        Context::add('block_article_list', new EloquentBlockArticleListRepository());
        Context::add('block_media', new EloquentBlockMediaRepository());
        Context::add('block_view', new EloquentBlockViewRepository());
    }
}
