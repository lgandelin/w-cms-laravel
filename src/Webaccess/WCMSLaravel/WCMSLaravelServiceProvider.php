<?php

namespace Webaccess\WCMSLaravel;

use CMS\Events\Events;

use CMS\Interactors\Langs\CreateLangInteractor;
use CMS\Interactors\Langs\DeleteLangInteractor;
use CMS\Interactors\Langs\GetLangInteractor;
use CMS\Interactors\Langs\GetLangsInteractor;
use CMS\Interactors\Langs\UpdateLangInteractor;
use CMS\Interactors\Pages\GetPageContentInteractor;
use Illuminate\Support\ServiceProvider;

use CMS\Interactors\Articles\CreateArticleInteractor;
use CMS\Interactors\Articles\DeleteArticleInteractor;
use CMS\Interactors\Articles\GetArticleInteractor;
use CMS\Interactors\Articles\GetArticlesInteractor;
use CMS\Interactors\Articles\UpdateArticleInteractor;

use CMS\Interactors\ArticleCategories\CreateArticleCategoryInteractor;
use CMS\Interactors\ArticleCategories\DeleteArticleCategoryInteractor;
use CMS\Interactors\ArticleCategories\GetArticleCategoriesInteractor;
use CMS\Interactors\ArticleCategories\GetArticleCategoryInteractor;
use CMS\Interactors\ArticleCategories\UpdateArticleCategoryInteractor;

use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Interactors\Pages\GetPagesInteractor;
use CMS\Interactors\Pages\CreatePageInteractor;
use CMS\Interactors\Pages\UpdatePageInteractor;
use CMS\Interactors\Pages\DeletePageInteractor;
use CMS\Interactors\Pages\DuplicatePageInteractor;
use CMS\Interactors\Pages\CreatePageFromMasterInteractor;
use CMS\Interactors\Pages\GetPageInfoFromMasterInteractor;

use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Interactors\Areas\DuplicateAreaInteractor;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Interactors\Areas\DeleteAreaInteractor;

use CMS\Interactors\Blocks\GetBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Interactors\Blocks\DeleteBlockInteractor;
use CMS\Interactors\Blocks\DuplicateBlockInteractor;
use CMS\Interactors\Blocks\GetBlockContentInteractor;

use CMS\Interactors\Menus\GetMenuInteractor;
use CMS\Interactors\Menus\GetMenusInteractor;
use CMS\Interactors\Menus\CreateMenuInteractor;
use CMS\Interactors\Menus\UpdateMenuInteractor;
use CMS\Interactors\Menus\DuplicateMenuInteractor;
use CMS\Interactors\Menus\DeleteMenuInteractor;

use CMS\Interactors\MenuItems\GetMenuItemInteractor;
use CMS\Interactors\MenuItems\GetMenuItemsInteractor;
use CMS\Interactors\MenuItems\CreateMenuItemInteractor;
use CMS\Interactors\MenuItems\UpdateMenuItemInteractor;
use CMS\Interactors\MenuItems\DeleteMenuItemInteractor;

use CMS\Interactors\Medias\CreateMediaInteractor;
use CMS\Interactors\Medias\DeleteMediaInteractor;
use CMS\Interactors\Medias\GetMediaInteractor;
use CMS\Interactors\Medias\GetMediasInteractor;
use CMS\Interactors\Medias\UpdateMediaInteractor;

use CMS\Interactors\MediaFormats\CreateMediaFormatInteractor;
use CMS\Interactors\MediaFormats\DeleteMediaFormatInteractor;
use CMS\Interactors\MediaFormats\GetMediaFormatInteractor;
use CMS\Interactors\MediaFormats\GetMediaFormatsInteractor;
use CMS\Interactors\MediaFormats\UpdateMediaFormatInteractor;

use CMS\Interactors\Users\GetUserInteractor;
use CMS\Interactors\Users\GetUsersInteractor;
use CMS\Interactors\Users\CreateUserInteractor;
use CMS\Interactors\Users\UpdateUserInteractor;
use CMS\Interactors\Users\DeleteUserInteractor;

use Webaccess\WCMSLaravel\Commands\CreateUserCommand;
use Webaccess\WCMSLaravel\Events\CMSLaravelEventManager;
use Webaccess\WCMSLaravel\Helpers\AdminMenu;
use Webaccess\WCMSLaravel\Helpers\ShortcutHelper;
use Webaccess\WCMSLaravel\Helpers\Theme;
use Webaccess\WCMSLaravel\Listeners\DeleteAreaListener;
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

        $this->commands(
            array('CreateUserCommand')
        );

        $this->app->bind('EventDispatcher', function() {
            $eventDispatcher = new CMSLaravelEventManager();
            $eventDispatcher->addListener(Events::DELETE_AREA, array(new DeleteAreaListener(), 'onDeleteArea'));

            return $eventDispatcher;
        });

        //Areas
        $this->app->bind('GetAreaInteractor', function() {
            return new GetAreaInteractor(new EloquentAreaRepository());
        });

        $this->app->bind('GetAreasInteractor', function() {
            return new GetAreasInteractor(new EloquentAreaRepository());
        });

        $this->app->bind('CreateAreaInteractor', function() {
            return new CreateAreaInteractor(
                new EloquentAreaRepository(),
                $this->app->make('GetPagesInteractor')
            );
        });

        $this->app->bind('UpdateAreaInteractor', function() {
            return new UpdateAreaInteractor(
                new EloquentAreaRepository(),
                $this->app->make('GetAreasInteractor')
            );
        });

        $this->app->bind('DeleteAreaInteractor', function() {
            $interactor = new DeleteAreaInteractor(
                new EloquentAreaRepository(),
                $this->app->make('GetAreasInteractor'),
                $this->app->make('GetBlocksInteractor'),
                $this->app->make('DeleteBlockInteractor')
            );
            $interactor->setEventManager($this->app->make('EventDispatcher'));

            return $interactor;
        });

        $this->app->bind('DuplicateAreaInteractor', function() {
            return new DuplicateAreaInteractor(
                $this->app->make('CreateAreaInteractor'),
                $this->app->make('UpdateAreaInteractor')
            );
        });


        //Blocks
        $this->app->bind('GetBlockInteractor', function() {
            return new GetBlockInteractor(new EloquentBlockRepository());
        });

        $this->app->bind('GetBlocksInteractor', function() {
            return new GetBlocksInteractor(new EloquentBlockRepository());
        });

        $this->app->bind('CreateBlockInteractor', function() {
            return new CreateBlockInteractor(
                new EloquentBlockRepository(),
                $this->app->make('GetAreasInteractor')
            );
        });

        $this->app->bind('UpdateBlockInteractor', function() {
            return new UpdateBlockInteractor(
                new EloquentBlockRepository(),
                $this->app->make('GetBlocksInteractor')
            );
        });

        $this->app->bind('DeleteBlockInteractor', function() {
            return new DeleteBlockInteractor(
                new EloquentBlockRepository(),
                $this->app->make('GetBlocksInteractor')
            );
        });

        $this->app->bind('DuplicateBlockInteractor', function() {
            return new DuplicateBlockInteractor(
                $this->app->make('CreateBlockInteractor'),
                $this->app->make('UpdateBlockInteractor')
            );
        });

        $this->app->bind('GetBlockContentInteractor', function() {
            return new GetBlockContentInteractor(
                $this->app->make('GetMenuInteractor'),
                $this->app->make('GetMenuItemsInteractor'),
                $this->app->make('GetPageInteractor'),
                $this->app->make('GetArticleInteractor'),
                $this->app->make('GetArticlesInteractor'),
                $this->app->make('GetUserInteractor'),
                $this->app->make('GetMediaInteractor'),
                $this->app->make('GetMediaFormatInteractor'),
                $this->app->make('GetBlockInteractor')
            );
        });


        //Menus
        $this->app->bind('CreateMenuInteractor', function() {
            return new CreateMenuInteractor(new EloquentMenuRepository());
        });

        $this->app->bind('GetMenuInteractor', function() {
            return new GetMenuInteractor(new EloquentMenuRepository());
        });

        $this->app->bind('GetMenusInteractor', function() {
            return new GetMenusInteractor(new EloquentMenuRepository());
        });

        $this->app->bind('UpdateMenuInteractor', function() {
            return new UpdateMenuInteractor(new EloquentMenuRepository());
        });

        $this->app->bind('DuplicateMenuInteractor', function() {
            return new DuplicateMenuInteractor(
                new EloquentMenuRepository(),
                $this->app->make('CreateMenuInteractor'),
                $this->app->make('GetMenuItemsInteractor'),
                $this->app->make('CreateMenuItemInteractor')
            );
        });

        $this->app->bind('DeleteMenuInteractor', function() {
            return new DeleteMenuInteractor(
                new EloquentMenuRepository(),
                $this->app->make('GetMenuItemsInteractor'),
                $this->app->make('DeleteMenuItemInteractor')
            );
        });


        //Menu items
        $this->app->bind('GetMenuItemInteractor', function() {
            return new GetMenuItemInteractor(new EloquentMenuItemRepository());
        });

        $this->app->bind('GetMenuItemsInteractor', function() {
            return new GetMenuItemsInteractor(new EloquentMenuItemRepository());
        });

        $this->app->bind('CreateMenuItemInteractor', function() {
            return new CreateMenuItemInteractor(new EloquentMenuItemRepository());
        });

        $this->app->bind('UpdateMenuItemInteractor', function() {
            return new UpdateMenuItemInteractor(new EloquentMenuItemRepository());
        });

        $this->app->bind('DeleteMenuItemInteractor', function() {
            return new DeleteMenuItemInteractor(new EloquentMenuItemRepository());
        });


        //Medias
        $this->app->bind('CreateMediaInteractor', function() {
            return new CreateMediaInteractor(new EloquentMediaRepository());
        });

        $this->app->bind('GetMediaInteractor', function() {
            return new GetMediaInteractor(new EloquentMediaRepository());
        });

        $this->app->bind('GetMediasInteractor', function() {
            return new GetMediasInteractor(new EloquentMediaRepository());
        });

        $this->app->bind('UpdateMediaInteractor', function() {
            return new UpdateMediaInteractor(new EloquentMediaRepository());
        });

        $this->app->bind('DeleteMediaInteractor', function() {
            return new DeleteMediaInteractor(new EloquentMediaRepository());
        });


        //MediaFormats
        $this->app->bind('CreateMediaFormatInteractor', function() {
            return new CreateMediaFormatInteractor(new EloquentMediaFormatRepository());
        });

        $this->app->bind('GetMediaFormatInteractor', function() {
            return new GetMediaFormatInteractor(new EloquentMediaFormatRepository());
        });

        $this->app->bind('GetMediaFormatsInteractor', function() {
            return new GetMediaFormatsInteractor(new EloquentMediaFormatRepository());
        });

        $this->app->bind('UpdateMediaFormatInteractor', function() {
            return new UpdateMediaFormatInteractor(new EloquentMediaFormatRepository());
        });

        $this->app->bind('DeleteMediaFormatInteractor', function() {
            return new DeleteMediaFormatInteractor(new EloquentMediaFormatRepository());
        });


        //Users
        $this->app->bind('GetUserInteractor', function() {
            return new GetUserInteractor(new EloquentUserRepository());
        });

        $this->app->bind('GetUsersInteractor', function() {
            return new GetUsersInteractor(new EloquentUserRepository());
        });

        $this->app->bind('CreateUserInteractor', function() {
            return new CreateUserInteractor(new EloquentUserRepository());
        });

        $this->app->bind('UpdateUserInteractor', function() {
            return new UpdateUserInteractor(new EloquentUserRepository());
        });

        $this->app->bind('DeleteUserInteractor', function() {
            return new DeleteUserInteractor(new EloquentUserRepository());
        });


        //Pages
        $this->app->bind('GetPageInteractor', function() {
            return new GetPageInteractor(new EloquentPageRepository());
        });

        $this->app->bind('GetPagesInteractor', function() {
            return new GetPagesInteractor(new EloquentPageRepository());
        });

        $this->app->bind('CreatePageInteractor', function() {
            return new CreatePageInteractor(new EloquentPageRepository());
        });

        $this->app->bind('CreatePageFromMasterInteractor', function() {
            return new CreatePageFromMasterInteractor(
                new EloquentPageRepository(),
                $this->app->make('CreatePageInteractor'),
                $this->app->make('GetAreasInteractor'),
                $this->app->make('UpdateAreaInteractor'),
                $this->app->make('DuplicateAreaInteractor'),
                $this->app->make('GetBlocksInteractor'),
                $this->app->make('UpdateBlockInteractor'),
                $this->app->make('DuplicateBlockInteractor')
            );
        });

        $this->app->bind('GetPageInfoFromMasterInteractor', function() {
            return new GetPageInfoFromMasterInteractor($this->app->make('GetPageInteractor'));
        });

        $this->app->bind('UpdatePageInteractor', function() {
            return new UpdatePageInteractor(
                new EloquentPageRepository(),
                $this->app->make('GetAreasInteractor'),
                $this->app->make('UpdateAreaInteractor'),
                $this->app->make('GetBlocksInteractor'),
                $this->app->make('UpdateBlockInteractor')
            );
        });

        $this->app->bind('DeletePageInteractor', function() {
            return new DeletePageInteractor(
                new EloquentPageRepository(),
                $this->app->make('GetAreasInteractor'),
                $this->app->make('DeleteAreaInteractor'),
                $this->app->make('GetArticlesInteractor'),
                $this->app->make('UpdateArticleInteractor')
            );
        });

        $this->app->bind('DuplicatePageInteractor', function() {
            return new DuplicatePageInteractor(
                new EloquentPageRepository(),
                $this->app->make('GetAreasInteractor'),
                $this->app->make('GetBlocksInteractor'),
                $this->app->make('CreatePageInteractor'),
                $this->app->make('DuplicateAreaInteractor'),
                $this->app->make('DuplicateBlockInteractor')
            );
        });

        $this->app->bind('GetPageContentInteractor', function() {
            return new GetPageContentInteractor(
                $this->app->make('GetLangInteractor'),
                $this->app->make('GetPageInteractor'),
                $this->app->make('GetAreasInteractor'),
                $this->app->make('GetBlocksInteractor'),
                $this->app->make('GetBlockContentInteractor')
            );
        });


        //Articles
        $this->app->bind('GetArticleInteractor', function() {
            return new GetArticleInteractor(new EloquentArticleRepository());
        });

        $this->app->bind('GetArticlesInteractor', function() {
            return new GetArticlesInteractor(new EloquentArticleRepository());
        });

        $this->app->bind('CreateArticleInteractor', function() {
            return new CreateArticleInteractor(new EloquentArticleRepository());
        });

        $this->app->bind('UpdateArticleInteractor', function() {
            return new UpdateArticleInteractor(new EloquentArticleRepository());
        });

        $this->app->bind('DeleteArticleInteractor', function() {
            return new DeleteArticleInteractor(new EloquentArticleRepository());
        });


        //Article categories
        $this->app->bind('GetArticleCategoryInteractor', function() {
            return new GetArticleCategoryInteractor(new EloquentArticleCategoryRepository());
        });

        $this->app->bind('GetArticleCategoriesInteractor', function() {
            return new GetArticleCategoriesInteractor(new EloquentArticleCategoryRepository());
        });

        $this->app->bind('CreateArticleCategoryInteractor', function() {
            return new CreateArticleCategoryInteractor(new EloquentArticleCategoryRepository());
        });

        $this->app->bind('UpdateArticleCategoryInteractor', function() {
            return new UpdateArticleCategoryInteractor(new EloquentArticleCategoryRepository());
        });

        $this->app->bind('DeleteArticleCategoryInteractor', function() {
            return new DeleteArticleCategoryInteractor(new EloquentArticleCategoryRepository());
        });


        //Langs
        $this->app->bind('CreateLangInteractor', function() {
            return new CreateLangInteractor(new EloquentLangRepository());
        });

        $this->app->bind('GetLangInteractor', function() {
            return new GetLangInteractor(
                new EloquentLangRepository(),
                $this->app->make('GetLangsInteractor')
            );
        });

        $this->app->bind('GetLangsInteractor', function() {
            return new GetLangsInteractor(new EloquentLangRepository());
        });

        $this->app->bind('UpdateLangInteractor', function() {
            return new UpdateLangInteractor(new EloquentLangRepository());
        });

        $this->app->bind('DeleteLangInteractor', function() {
            return new DeleteLangInteractor(new EloquentLangRepository());
        });
    }
}
