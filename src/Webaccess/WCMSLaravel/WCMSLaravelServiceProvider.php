<?php namespace Webaccess\WCMSLaravel;

use Illuminate\Support\ServiceProvider;
use CMS\Services\PageManager;
use CMS\Services\MenuManager;
use CMS\Services\UserManager;
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

		$this->app->bind('\CMS\Services\UserManager', function() {
			return new UserManager(new EloquentUserRepository());
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
