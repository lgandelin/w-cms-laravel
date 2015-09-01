<?php

namespace Webaccess\WCMSLaravel;

use CMS\Context;
use Illuminate\Support\ServiceProvider;

use Webaccess\WCMSLaravel\Commands\CreateUserCommand;
use Webaccess\WCMSLaravel\Commands\CreateThemeCommand;
use Webaccess\WCMSLaravel\Commands\InitCommand;
use Webaccess\WCMSLaravel\Commands\PublishThemeCommand;
use Webaccess\WCMSLaravel\Helpers\ShortcutHelper;
use Webaccess\WCMSLaravel\Repositories\JSON\Blocks\JSONBlockArticleListRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\Blocks\JSONBlockArticleRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\Blocks\JSONBlockHTMLRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\Blocks\JSONBlockMediaRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\Blocks\JSONBlockMenuRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\Blocks\JSONBlockViewRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\JSONAreaRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\JSONArticleCategoryRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\JSONArticleRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\JSONBlockRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\JSONBlockTypeRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\JSONLangRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\JSONMediaFormatRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\JSONMediaRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\JSONMenuItemRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\JSONMenuRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\JSONPageRepository;
use Webaccess\WCMSLaravel\Repositories\JSON\JSONUserRepository;

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

        $this->app->bind('PublishThemeCommand', function() {
            return new PublishThemeCommand();
        });

        $this->app->bind('InitCommand', function() {
            return new InitCommand();
        });

        $this->commands(
            array('CreateUserCommand', 'GenerateThemeCommand', 'PublishThemeCommand', 'InitCommand')
        );

        //Init repositories
        Context::add('block_html', new JSONBlockHTMLRepository());
        Context::add('block_menu', new JSONBlockMenuRepository());
        Context::add('block_article', new JSONBlockArticleRepository());
        Context::add('block_article_list', new JSONBlockArticleListRepository());
        Context::add('block_media', new JSONBlockMediaRepository());
        Context::add('block_view', new JSONBlockViewRepository());

        Context::add('page', new JSONPageRepository());
        Context::add('area', new JSONAreaRepository());
        Context::add('block', new JSONBlockRepository());
        Context::add('lang', new JSONLangRepository());
        Context::add('menu', new JSONMenuRepository());
        Context::add('menu_item', new JSONMenuItemRepository());
        Context::add('media', new JSONMediaRepository());
        Context::add('media_format', new JSONMediaFormatRepository());
        Context::add('article', new JSONArticleRepository());
        Context::add('user', new JSONUserRepository());
        Context::add('article_category', new JSONArticleCategoryRepository());
        Context::add('block_type', new JSONBlockTypeRepository());
    }
}
