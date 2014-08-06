<?php

namespace Webaccess\WCMSLaravel\Front;

use Illuminate\Routing\Controller;

class IndexController extends Controller {

	public function index($uri = null)
	{
		try {
            $page = \App::make('GetPageInteractor')->getByUri('/' . $uri);
        } catch(\Exception $e) {
            $page = \App::make('GetPageInteractor')->getByUri('/404');
        }

		$this->layout = \View::make('w-cms-laravel::front.index', [
			'current_page' => $page,
			'menu' => \App::make('GetMenuInteractor')->getByIdentifier('main-menu')
		]);
	}
}