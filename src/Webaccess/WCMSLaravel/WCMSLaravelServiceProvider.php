<?php namespace Webaccess\WCMSLaravel;

use Illuminate\Support\ServiceProvider;

use CreateUserCommand;

use CMS\Interactors\Articles\CreateArticleInteractor;
use CMS\Interactors\Articles\DeleteArticleInteractor;
use CMS\Interactors\Articles\GetArticleInteractor;
use CMS\Interactors\Articles\GetArticlesInteractor;
use CMS\Interactors\Articles\UpdateArticleInteractor;

use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Interactors\Pages\GetPagesInteractor;
use CMS\Interactors\Pages\CreatePageInteractor;
use CMS\Interactors\Pages\UpdatePageInteractor;
use CMS\Interactors\Pages\DeletePageInteractor;
use CMS\Interactors\Pages\DuplicatePageInteractor;

use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Interactors\Areas\DeleteAreaInteractor;

use CMS\Interactors\Blocks\GetBlockInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Interactors\Blocks\DeleteBlockInteractor;

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

use CMS\Interactors\Users\GetUserInteractor;
use CMS\Interactors\Users\GetUsersInteractor;
use CMS\Interactors\Users\CreateUserInteractor;
use CMS\Interactors\Users\UpdateUserInteractor;
use CMS\Interactors\Users\DeleteUserInteractor;

use Webaccess\WCMSLaravel\Repositories\EloquentAreaRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentArticleRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentBlockRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentPageRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentMenuRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentMenuItemRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentUserRepository;

class WCMSLaravelServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('webaccess/w-cms-laravel');
        include(__DIR__ . '/../../routes.php');

        $this->app->bind('CreateUserCommand', function($app) {
            return new CreateUserCommand();
        });

        $this->commands(array(
            'CreateUserCommand'
        ));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //Areas
        $this->app->bind('GetAreaInteractor', function () {
            return new GetAreaInteractor(new EloquentAreaRepository());
        });

        $this->app->bind('GetAreasInteractor', function () {
            return new GetAreasInteractor(new EloquentAreaRepository());
        });

        $this->app->bind('CreateAreaInteractor', function () {
            return new CreateAreaInteractor(new EloquentAreaRepository());
        });

        $this->app->bind('UpdateAreaInteractor', function () {
            return new UpdateAreaInteractor(new EloquentAreaRepository());
        });

        $this->app->bind('DeleteAreaInteractor', function () {
            return new DeleteAreaInteractor(new EloquentAreaRepository(), $this->app->make('GetBlocksInteractor'), $this->app->make('DeleteBlockInteractor'));
        });


        //Blocks
        $this->app->bind('GetBlockInteractor', function () {
            return new GetBlockInteractor(new EloquentBlockRepository());
        });

        $this->app->bind('GetBlocksInteractor', function () {
            return new GetBlocksInteractor(new EloquentBlockRepository());
        });

        $this->app->bind('CreateBlockInteractor', function () {
            return new CreateBlockInteractor(new EloquentBlockRepository());
        });

        $this->app->bind('UpdateBlockInteractor', function () {
            return new UpdateBlockInteractor(new EloquentBlockRepository());
        });

        $this->app->bind('DeleteBlockInteractor', function () {
            return new DeleteBlockInteractor(new EloquentBlockRepository());
        });


        //Menus
        $this->app->bind('CreateMenuInteractor', function () {
            return new CreateMenuInteractor(new EloquentMenuRepository());
        });

        $this->app->bind('GetMenuInteractor', function () {
            return new GetMenuInteractor(new EloquentMenuRepository());
        });

        $this->app->bind('GetMenusInteractor', function () {
            return new GetMenusInteractor(new EloquentMenuRepository());
        });

        $this->app->bind('UpdateMenuInteractor', function () {
            return new UpdateMenuInteractor(new EloquentMenuRepository());
        });

        $this->app->bind('DuplicateMenuInteractor', function () {
            return new DuplicateMenuInteractor(new EloquentMenuRepository(), $this->app->make('CreateMenuInteractor'), $this->app->make('GetMenuItemsInteractor'), $this->app->make('CreateMenuItemInteractor'));
        });

        $this->app->bind('DeleteMenuInteractor', function () {
            return new DeleteMenuInteractor(new EloquentMenuRepository(), $this->app->make('GetMenuItemsInteractor'), $this->app->make('DeleteMenuItemInteractor'));
        });


        //Menu items
        $this->app->bind('GetMenuItemInteractor', function () {
            return new GetMenuItemInteractor(new EloquentMenuItemRepository());
        });

        $this->app->bind('GetMenuItemsInteractor', function () {
            return new GetMenuItemsInteractor(new EloquentMenuItemRepository());
        });

        $this->app->bind('CreateMenuItemInteractor', function () {
            return new CreateMenuItemInteractor(new EloquentMenuItemRepository());
        });

        $this->app->bind('UpdateMenuItemInteractor', function () {
            return new UpdateMenuItemInteractor(new EloquentMenuItemRepository());
        });

        $this->app->bind('DeleteMenuItemInteractor', function () {
            return new DeleteMenuItemInteractor(new EloquentMenuItemRepository());
        });


        //Users
        $this->app->bind('GetUserInteractor', function () {
            return new GetUserInteractor(new EloquentUserRepository());
        });

        $this->app->bind('GetUsersInteractor', function () {
            return new GetUsersInteractor(new EloquentUserRepository());
        });

        $this->app->bind('CreateUserInteractor', function () {
            return new CreateUserInteractor(new EloquentUserRepository());
        });

        $this->app->bind('UpdateUserInteractor', function () {
            return new UpdateUserInteractor(new EloquentUserRepository());
        });

        $this->app->bind('DeleteUserInteractor', function () {
            return new DeleteUserInteractor(new EloquentUserRepository());
        });


        //Pages
        $this->app->bind('GetPageInteractor', function () {
            return new GetPageInteractor(new EloquentPageRepository());
        });

        $this->app->bind('GetPagesInteractor', function () {
            return new GetPagesInteractor(new EloquentPageRepository());
        });

        $this->app->bind('CreatePageInteractor', function () {
            return new CreatePageInteractor(new EloquentPageRepository());
        });

        $this->app->bind('UpdatePageInteractor', function () {
            return new UpdatePageInteractor(new EloquentPageRepository());
        });

        $this->app->bind('DeletePageInteractor', function () {
            return new DeletePageInteractor(new EloquentPageRepository(), $this->app->make('GetAreasInteractor'),$this->app->make('DeleteAreaInteractor'));
        });

        $this->app->bind('DuplicatePageInteractor', function () {
            return new DuplicatePageInteractor(new EloquentPageRepository(), $this->app->make('GetAreasInteractor'), $this->app->make('GetBlocksInteractor'), $this->app->make('CreatePageInteractor'), $this->app->make('CreateAreaInteractor'), $this->app->make('CreateBlockInteractor'), $this->app->make('UpdateBlockInteractor'));
        });


        //Articles
        $this->app->bind('GetArticleInteractor', function () {
            return new GetArticleInteractor(new EloquentArticleRepository());
        });

        $this->app->bind('GetArticlesInteractor', function () {
            return new GetArticlesInteractor(new EloquentArticleRepository());
        });

        $this->app->bind('CreateArticleInteractor', function () {
            return new CreateArticleInteractor(new EloquentArticleRepository());
        });

        $this->app->bind('UpdateArticleInteractor', function () {
            return new UpdateArticleInteractor(new EloquentArticleRepository());
        });

        $this->app->bind('DeleteArticleInteractor', function () {
            return new DeleteArticleInteractor(new EloquentArticleRepository());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
