<?php namespace Webaccess\WCMSLaravel;

use Illuminate\Support\ServiceProvider;
use CMS\Interactors\Users\GetUserInteractor;
use CMS\Interactors\Users\GetAllUsersInteractor;
use CMS\Interactors\Users\CreateUserInteractor;
use CMS\Interactors\Users\UpdateUserInteractor;
use CMS\Interactors\Users\DeleteUserInteractor;
use CMS\Services\PageManager;
use CMS\Services\MenuManager;
use Webaccess\WCMSLaravel\Repositories\EloquentPageRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentMenuRepository;
use Webaccess\WCMSLaravel\Repositories\EloquentUserRepository;

class WCMSLaravelServiceProvider extends ServiceProvider {

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
		$this->app->bind('\CMS\Services\PageManager', function() {
			return new PageManager(new EloquentPageRepository());
		});

		$this->app->bind('\CMS\Services\MenuManager', function() {
			return new MenuManager(new EloquentMenuRepository(), new EloquentPageRepository());
		});

		$this->app->bind('\CMS\Interactors\GetUserInteractor', function() {
			return new GetUserInteractor(new EloquentUserRepository());
		});

		$this->app->bind('\CMS\Interactors\GetAllUsersInteractor', function() {
			return new GetAllUsersInteractor(new EloquentUserRepository());
		});

		$this->app->bind('\CMS\Interactors\CreateUserInteractor', function() {
			return new CreateUserInteractor(new EloquentUserRepository());
		});

		$this->app->bind('\CMS\Interactors\UpdateUserInteractor', function() {
			return new UpdateUserInteractor(new EloquentUserRepository());
		});

		$this->app->bind('\CMS\Interactors\DeleteUserInteractor', function() {
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
