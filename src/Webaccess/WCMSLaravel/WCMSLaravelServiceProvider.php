<?php namespace Webaccess\WCMSLaravel;

use Illuminate\Support\ServiceProvider;

use CMS\Interactors\Pages\GetPageInteractor;
use CMS\Interactors\Pages\GetAllPagesInteractor;
use CMS\Interactors\Pages\CreatePageInteractor;
use CMS\Interactors\Pages\UpdatePageInteractor;
use CMS\Interactors\Pages\DeletePageInteractor;
use CMS\Interactors\Pages\DuplicatePageInteractor;

use CMS\Interactors\Areas\GetAreaInteractor;
use CMS\Interactors\Areas\GetAllAreasInteractor;
use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Interactors\Areas\DeleteAreaInteractor;

use CMS\Interactors\Blocks\GetBlockInteractor;
use CMS\Interactors\Blocks\GetAllBlocksInteractor;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Interactors\Blocks\DeleteBlockInteractor;

use CMS\Interactors\Menus\GetMenuInteractor;
use CMS\Interactors\Menus\GetAllMenusInteractor;
use CMS\Interactors\Menus\CreateMenuInteractor;
use CMS\Interactors\Menus\UpdateMenuInteractor;
use CMS\Interactors\Menus\DuplicateMenuInteractor;
use CMS\Interactors\Menus\DeleteMenuInteractor;
use CMS\Interactors\Menus\AddMenuItemInteractor;
use CMS\Interactors\Menus\UpdateMenuItemInteractor;
use CMS\Interactors\Menus\DeleteMenuItemInteractor;

use CMS\Interactors\Users\GetUserInteractor;
use CMS\Interactors\Users\GetAllUsersInteractor;
use CMS\Interactors\Users\CreateUserInteractor;
use CMS\Interactors\Users\UpdateUserInteractor;
use CMS\Interactors\Users\DeleteUserInteractor;

use Webaccess\WCMSLaravel\Repositories\EloquentAreaRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentBlockRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentPageRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentMenuRepository;
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
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //Pages
        $this->app->bind('GetPageInteractor', function () {
            return new GetPageInteractor(new EloquentPageRepository());
        });

        $this->app->bind('GetAllPagesInteractor', function () {
            return new GetAllPagesInteractor(new EloquentPageRepository());
        });

        $this->app->bind('CreatePageInteractor', function () {
            return new CreatePageInteractor(new EloquentPageRepository());
        });

        $this->app->bind('UpdatePageInteractor', function () {
            return new UpdatePageInteractor(new EloquentPageRepository());
        });

        $this->app->bind('DeletePageInteractor', function () {
            return new DeletePageInteractor(new EloquentPageRepository());
        });

        $this->app->bind('DuplicatePageInteractor', function () {
            return new DuplicatePageInteractor(new EloquentPageRepository());
        });


        //Areas
        $this->app->bind('GetAreaInteractor', function () {
            return new GetAreaInteractor(new EloquentAreaRepository());
        });

        $this->app->bind('GetAllAreasInteractor', function () {
            return new GetAllAreasInteractor(new EloquentAreaRepository(), new EloquentPageRepository());
        });

        $this->app->bind('CreateAreaInteractor', function () {
            return new CreateAreaInteractor(new EloquentAreaRepository(), new EloquentPageRepository());
        });

        $this->app->bind('UpdateAreaInteractor', function () {
            return new UpdateAreaInteractor(new EloquentAreaRepository());
        });

        $this->app->bind('DeleteAreaInteractor', function () {
            return new DeleteAreaInteractor(new EloquentAreaRepository(), new EloquentBlockRepository());
        });


        //Blocks
        $this->app->bind('GetBlockInteractor', function () {
            return new GetBlockInteractor(new EloquentBlockRepository());
        });

        $this->app->bind('GetAllBlocksInteractor', function () {
            return new GetAllBlocksInteractor(new EloquentBlockRepository());
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

        $this->app->bind('GetAllMenusInteractor', function () {
            return new GetAllMenusInteractor(new EloquentMenuRepository());
        });

        $this->app->bind('UpdateMenuInteractor', function () {
            return new UpdateMenuInteractor(new EloquentMenuRepository());
        });

        $this->app->bind('DuplicateMenuInteractor', function () {
            return new DuplicateMenuInteractor(new EloquentMenuRepository());
        });

        $this->app->bind('DeleteMenuInteractor', function () {
            return new DeleteMenuInteractor(new EloquentMenuRepository());
        });

        $this->app->bind('AddMenuItemInteractor', function () {
            return new AddMenuItemInteractor(new EloquentMenuRepository(), new EloquentPageRepository());
        });

        $this->app->bind('UpdateMenuItemInteractor', function () {
            return new UpdateMenuItemInteractor(new EloquentMenuRepository(), new EloquentPageRepository());
        });

        $this->app->bind('DeleteMenuItemInteractor', function () {
            return new DeleteMenuItemInteractor(new EloquentMenuRepository());
        });


        //Users
        $this->app->bind('GetUserInteractor', function () {
            return new GetUserInteractor(new EloquentUserRepository());
        });

        $this->app->bind('GetAllUsersInteractor', function () {
            return new GetAllUsersInteractor(new EloquentUserRepository());
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
