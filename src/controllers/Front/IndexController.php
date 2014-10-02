<?php

namespace Webaccess\WCMSLaravel\Front;

use Illuminate\Routing\Controller;

class IndexController extends Controller {

	public function index($uri = null)
	{
		try {
            $page = \App::make('GetPageInteractor')->getByUri('/' . $uri);
            $areas = \App::make('GetAllAreasInteractor')->getAll($page->ID);
            if ($areas) {
                foreach ($areas as $area) {
                    $blocks = \App::make('GetAllBlocksInteractor')->getAll($area->ID);
                    foreach ($blocks as $block) {
                        if ($block->menu_id) $block->menu = \App::make('GetMenuInteractor')->getByID($block->menu_id);
                        $area->blocks[]= $block;
                    }
                    $page->areas[]= $area;
                }
            }

        } catch(\Exception $e) {
            $page = \App::make('GetPageInteractor')->getByUri('/404');
        }

		$this->layout = \View::make('w-cms-laravel::front.index', [
			'current_page' => $page,
			'menu' => \App::make('GetMenuInteractor')->getByIdentifier('main-menu')
		]);
	}
}