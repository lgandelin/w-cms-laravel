<?php

namespace Webaccess\WCMSLaravel\Front;

use CMS\Structures\Blocks\ArticleBlockStructure;
use CMS\Structures\Blocks\ArticleListBlockStructure;
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
                        if ($block instanceof MenuBlockStructure && $block->menu_id) {
                            $block->menu = \App::make('GetMenuInteractor')->getMenuByID($block->menu_id, true);
                            $menuItems = \App::make('GetMenuItemsInteractor')->getAll($block->menu_id, true);

                            foreach ($menuItems as $menuItem)
                                if ($menuItem->page_id)
                                    $menuItem->page = \App::make('GetPageInteractor')->getPageByID($menuItem->page_id, true);

                            $block->menu->items =$menuItems;
                        }

                        elseif ($block instanceof ArticleBlockStructure && $block->article_id) {
                            $block->article = \App::make('GetArticleInteractor')->getArticleByID($block->article_id, true);

                            if ($block->article->author_id)
                                $block->article->author = \App::make('GetUserInteractor')->getUserByID($block->article->author_id, true);
                        }

                        elseif ($block instanceof ArticleListBlockStructure) {
                            $block->articles = array();
                            if ($block->article_list_category_id) {
                                $block->articles = \App::make('GetArticlesInteractor')->getByCategoryID($block->article_list_category_id, $block->article_list_number, $block->article_list_order, true);
                            }
                        }

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