<?php

namespace Webaccess\WCMSLaravel;

use CMS\Context;
use CMS\Events\Events;
use Illuminate\Support\ServiceProvider;

use Webaccess\WCMSLaravel\BlockTypes\ArticleBlockType;
use Webaccess\WCMSLaravel\BlockTypes\ArticleListBlockType;
use Webaccess\WCMSLaravel\BlockTypes\MediaBlockType;
use Webaccess\WCMSLaravel\BlockTypes\MenuBlockType;
use Webaccess\WCMSLaravel\BlockTypes\ViewBlockType;
use Webaccess\WCMSLaravel\Commands\CreateUserCommand;
use Webaccess\WCMSLaravel\Events\CMSLaravelEventManager;
use Webaccess\WCMSLaravel\Helpers\AdminMenu;
use Webaccess\WCMSLaravel\Helpers\BlockTypeHelper;
use Webaccess\WCMSLaravel\BlockTypes\HTMLBlockType;
use Webaccess\WCMSLaravel\Helpers\BlockTypesVariable;
use Webaccess\WCMSLaravel\Helpers\ShortcutHelper;
use Webaccess\WCMSLaravel\Helpers\Theme;
use Webaccess\WCMSLaravel\Listeners\DeleteAreaListener;
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
            __DIR__.'/../../database/migrations/' => base_path('/database/migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../public/back' => base_path('/public/vendor/w-cms-laravel/back')
        ], 'back_assets');

        //Add standard block types
        $this->app->make('block_type')->addBlockType(new HTMLBlockType());
        $this->app->make('block_type')->addBlockType(new MenuBlockType());
        $this->app->make('block_type')->addBlockType(new ViewBlockType());
        $this->app->make('block_type')->addBlockType(new MediaBlockType());
        $this->app->make('block_type')->addBlockType(new ArticleBlockType());
        $this->app->make('block_type')->addBlockType(new ArticleListBlockType());

        //Load the theme
        Theme::load();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('AdminMenu', function()
        {
            return new AdminMenu();
        });

        $this->app->singleton('BlockTypesVariable', function()
        {
            return new BlockTypesVariable();
        });

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();

        //Facades
        $this->app->bind('shortcut', function()
        {
            return new ShortcutHelper();
        });
        $loader->alias('Shortcut', 'Webaccess\WCMSLaravel\Facades\Shortcut');

        $this->app->singleton('block_type', function()
        {
            return new BlockTypeHelper();
        });
        $loader->alias('BlockType', 'Webaccess\WCMSLaravel\Facades\BlockType');

        $loader->alias('Form', 'Illuminate\Html\FormFacade');
        $loader->alias('HTML', 'Illuminate\Html\HtmlFacade');

        $this->app->register('Illuminate\Html\HtmlServiceProvider');


        //Commands
        $this->app->bind('CreateUserCommand', function() {
            return new CreateUserCommand();
        });

        $this->commands(
            array('CreateUserCommand')
        );

        $this->app->bind('EventDispatcher', function() {
            $eventDispatcher = new CMSLaravelEventManager();
            $eventDispatcher->addListener(Events::DELETE_AREA, array(new DeleteAreaListener(), 'onDeleteArea'));

            return $eventDispatcher;
        });

        //Init Context
        Context::addRepository('page', new EloquentPageRepository());
        Context::addRepository('area', new EloquentAreaRepository());
        Context::addRepository('lang', new EloquentLangRepository());
        Context::addRepository('block', new EloquentBlockRepository());
        Context::addRepository('menu', new EloquentMenuRepository());
        Context::addRepository('menu_item', new EloquentMenuItemRepository());
        Context::addRepository('article', new EloquentArticleRepository());
        Context::addRepository('article_category', new EloquentArticleCategoryRepository());
        Context::addRepository('media', new EloquentMediaRepository());
        Context::addRepository('media_format', new EloquentMediaFormatRepository());
        Context::addRepository('user', new EloquentUserRepository());

        Context::addRepository('block_html', new EloquentBlockHTMLRepository());
        Context::addRepository('block_menu', new EloquentBlockMenuRepository());
        Context::addRepository('block_article', new EloquentBlockArticleRepository());
        Context::addRepository('block_article_list', new EloquentBlockArticleListRepository());
        Context::addRepository('block_media', new EloquentBlockMediaRepository());
        Context::addRepository('block_view', new EloquentBlockViewRepository());
    }
}
