<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\Blocks\MediaBlockStructure;
use CMS\Structures\PageStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class PageController extends AdminController
{
	public function index()
	{
		$this->layout = \View::make('w-cms-laravel::back.editorial.pages.index', [
			'pages' => \App::make('GetPagesInteractor')->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
		]);
	}

	public function create()
	{
		$this->layout = \View::make('w-cms-laravel::back.editorial.pages.create', [
            'master_pages' => \App::make('GetPagesInteractor')->getMasterPages(true),
        ]);
	}

	public function store()
	{
        $pageStructure = new PageStructure([
		    'name' => \Input::get('name'),
		    'uri' => \Input::get('uri'),
		    'identifier' => \Input::get('identifier'),
            'master_page_id' => \Input::get('master_page_id'),
            'is_master' => \Input::get('is_master')
		]);
		
		try {
            if ($pageStructure->master_page_id)
                $pageID = \App::make('CreatePageFromMasterInteractor')->run($pageStructure);
            else
                $pageID = \App::make('CreatePageInteractor')->run($pageStructure);

			return \Redirect::route('back_pages_edit', array('pageID' => $pageID));
		} catch (\Exception $e) {
			$this->layout = \View::make('w-cms-laravel::back.editorial.pages.create', [
				'error' => $e->getMessage(),
				'page' => $pageStructure
			]);
		}
	}

	public function edit($pageID)
	{
		try {
            $page = \App::make('GetPageInteractor')->getPageByID($pageID, true);
            $areas = \App::make('GetAreasInteractor')->getAll($pageID, true);

            if ($areas) {
                foreach ($areas as $area) {
                    $area->blocks = \App::make('GetBlocksInteractor')->getAllByAreaID($area->ID, true);
                    foreach ($area->blocks as $i => $block) {
                        if ($block instanceof MediaBlockStructure && $block->media_id) {
                            $block->media = \App::make('GetMediaInteractor')->getMediaByID($block->media_id, true);
                        }
                        $area->blocks[$i]= $block;
                    }
                    $page->areas[]= $area;
                }
            }

		    $this->layout = \View::make('w-cms-laravel::back.editorial.pages.edit', [
		        'page' => $page,
                'menus' => \App::make('GetMenusInteractor')->getAll(true),
                'articles' => \App::make('GetArticlesInteractor')->getAll(true),
                'article_categories' => \App::make('GetArticleCategoriesInteractor')->getAll(true),
                'global_blocks' => \App::make('GetBlocksInteractor')->getGlobalBlocks(true),
                'medias' => \App::make('GetMediasInteractor')->getAll(true),
                'media_formats' => \App::make('GetMediaFormatsInteractor')->getAll(true)
		    ]);
		} catch (\Exception $e) {
			\Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
		}
	}

    public function update_infos()
    {
        $pageID = \Input::get('ID');
        $pageStructure = new PageStructure([
            'name' => \Input::get('name'),
            'identifier' => \Input::get('identifier'),
            'is_master' => \Input::get('is_master'),
        ]);

        try {
            \App::make('UpdatePageInteractor')->run($pageID, $pageStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_seo()
    {
        $pageID = \Input::get('ID');
        $pageStructure = new PageStructure([
            'uri' => \Input::get('uri'),
            'meta_title' => \Input::get('meta_title'),
            'meta_description' => \Input::get('meta_description'),
            'meta_keywords' => \Input::get('meta_keywords')
        ]);

        try {
            \App::make('UpdatePageInteractor')->run($pageID, $pageStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function delete($pageID)
    {
        try {
            \App::make('DeletePageInteractor')->run($pageID);
            return \Redirect::route('back_pages_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
        }
    }

    public function duplicate($pageID)
    {
        try {
            \App::make('DuplicatePageInteractor')->run($pageID);
            return \Redirect::route('back_pages_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
        }
    }
}