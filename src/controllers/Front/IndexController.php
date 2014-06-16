<?php

namespace Webaccess\WCMSLaravel\Front;

class IndexController extends \Illuminate\Routing\Controller {

	public function __construct()
	{
		$this->pageManager = new \CMS\Services\PageManager(new \Webaccess\WCMSLaravel\Repositories\EloquentPageRepository());
	}

	public function index($uri = null)
	{
		try {
            $page = $this->pageManager->getByUri('/' . $uri);
        } catch(\Exception $e) {
            $page = $this->pageManager->getByUri('/404');
        }

		$this->layout = \View::make('w-cms-laravel::front.index', array(
			'current_page' => $page,
			'pages' => $this->pageManager->getAll())
		);
	}
}