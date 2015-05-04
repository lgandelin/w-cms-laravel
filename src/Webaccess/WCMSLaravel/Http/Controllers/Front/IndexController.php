<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front;

use Illuminate\Routing\Controller;
use CMS\Structures\Blocks\ArticleBlockStructure;
use CMS\Structures\Blocks\ArticleListBlockStructure;
use CMS\Structures\Blocks\GlobalBlockStructure;
use CMS\Structures\Blocks\MediaBlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use Webaccess\WCMSLaravel\Facades\Shortcut;

class IndexController extends Controller {

    public function __construct()
    {
        $this->setupTheme();
    }

	public function index($uri = null)
	{
        if ($uri != '/') $uri = '/' . $uri;
        list($langID, $uri) = $this->extractLangFromURI($uri);

		try {
            $page = \App::make('GetPageInteractor')->getPageByUri($uri, $langID, true);
            $areas = \App::make('GetAreasInteractor')->getAll($page->ID, true);

            if ($areas) {
                foreach ($areas as $area) {
                    $blocks = \App::make('GetBlocksInteractor')->getAllByAreaID($area->ID, true);
                    foreach ($blocks as $block) {
                        $area->blocks[]= $this->gatherBlockInfos($block);
                    }
                    $page->areas[]= $area;
                }
            }

        } catch(\Exception $e) {
            $page = \App::make('GetPageInteractor')->getPageByUri('/404', true);
        }

		return view(Shortcut::get_theme() . '::pages.index', [
			'page' => $page
		]);
	}

    public function gatherBlockInfos($block)
    {
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

            if ($block->article->page_id)
                $block->article->page = \App::make('GetPageInteractor')->getPageByID($block->article->page_id, true);
        }

        elseif ($block instanceof ArticleListBlockStructure) {
            $block->articles = array();
            $block->articles = \App::make('GetArticlesInteractor')->getAll(true, $block->article_list_category_id, $block->article_list_number, $block->article_list_order);
            foreach ($block->articles as $article) {
                if ($article->page_id)
                    $article->page = \App::make('GetPageInteractor')->getPageByID($article->page_id, true);

                if ($article->media_id)
                    $article->media = \App::make('GetMediaInteractor')->getMediaByID($article->media_id, true);
            }
        }
        
        else if ($block instanceof GlobalBlockStructure) {

            if ($block->block_reference_id !== null) {
                $oldBlock = $block;
                $block = \App::make('GetBlockInteractor')->getBlockByID($block->block_reference_id, true);
                $block = $this->gatherBlockInfos($block);

                $block->ID = $oldBlock->ID;
                $block->display = $oldBlock->display;
                $block->area_id = $oldBlock->area_id;
                $block->name = $oldBlock->name;
                $block->class .= ' ' . $oldBlock->class;
                $block->width  = $oldBlock->width;
                $block->height = $oldBlock->height;
            }
        }
        
        else if ($block instanceof MediaBlockStructure && $block->media_id) {
            $block->media = \App::make('GetMediaInteractor')->getMediaByID($block->media_id, true);

            if ($block->media_format_id) {
                $mediaFormat = \App::make('GetMediaFormatInteractor')->getMediaFormatByID($block->media_format_id, true);
                $block->media->file_name = $mediaFormat->width . '_' . $mediaFormat->height . '_' . $block->media->file_name;
            }
        }

        return $block;
    }

    private function extractLangFromURI($uri)
    {
        $langID = \App::make('GetLangInteractor')->getDefaultLangID();
        foreach (\App::make('GetLangsInteractor')->getAll(true) as $lang) {
            if (preg_match('#' . $lang->prefix . '#', $uri, $matches)) {
                if ($lang->prefix == $uri) {
                    $uri = $lang->prefix . '/';
                }

                if (count($matches) > 0) {
                    $langID = $lang->ID;
                }
            }
        }

        return [$langID, $uri];
    }

    private function setupTheme()
    {
        \View::addNamespace(Shortcut::get_theme(), base_path() . '/themes/' . Shortcut::get_theme() . '/views');
        \Lang::addNamespace(Shortcut::get_theme(), base_path() . '/themes/' . Shortcut::get_theme() . '/langs');
    }
}