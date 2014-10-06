<?php

namespace Webaccess\WCMSLaravel\Front;

use Illuminate\Routing\Controller;

use CMS\Structures\Blocks\MenuBlockStructure;

class IndexController extends Controller {

	public function index($uri = null)
	{
		try {
            $page = \App::make('GetPageInteractor')->getPageByUri('/' . $uri, true);
            $areas = \App::make('GetAreasInteractor')->getAll($page->ID, true);

            if ($areas) {
                foreach ($areas as $area) {
                    $blocks = \App::make('GetBlocksInteractor')->getAll($area->ID, true);
                    foreach ($blocks as $block) {
                        if ($block instanceof MenuBlockStructure && $block->menu_id)
                            $block->menu = \App::make('GetMenuInteractor')->getByID($block->menu_id);

                        $area->blocks[]= $block;
                    }
                    $page->areas[]= $area;
                }
            }
        } catch(\Exception $e) {
            $page = \App::make('GetPageInteractor')->getPageByUri('/404', true);
        }

		$this->layout = \View::make('w-cms-laravel::front.index', [
			'current_page' => $page,
		]);
	}
}