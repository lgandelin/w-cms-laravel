<?php

namespace Webaccess\WCMSLaravel\Front;

class IndexController extends \Illuminate\Routing\Controller {

	public function __construct()
	{
		$this->pageManager = new \CMS\Services\PageManager(new \Webaccess\WCMSLaravel\Repositories\EloquentPageRepository());
		$this->menuManager = new \CMS\Services\MenuManager(new \Webaccess\WCMSLaravel\Repositories\EloquentMenuRepository());
	}

	public function index($uri = null)
	{
		try {
            $page = $this->pageManager->getByUri('/' . $uri);
        } catch(\Exception $e) {
            $page = $this->pageManager->getByUri('/404');
        }

		$this->layout = \View::make('w-cms-laravel::front.index', [
			'current_page' => $page,
			'menu' => $this->menuManager->getByIdentifier('main-menu')
		]);
	}
}