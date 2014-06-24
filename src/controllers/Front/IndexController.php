<?php

namespace Webaccess\WCMSLaravel\Front;

use CMS\Services\PageManager;
use CMS\Services\MenuManager;
use Illuminate\Routing\Controller;

class IndexController extends Controller {

	public function __construct(PageManager $pageManager, MenuManager $menuManager)
	{
		$this->pageManager = $pageManager;
		$this->menuManager = $menuManager;
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