<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

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
		$this->layout = \View::make('w-cms-laravel::back.editorial.pages.create');
	}

	public function store()
	{
        $pageStructure = new PageStructure([
		    'name' => \Input::get('name'),
		    'uri' => \Input::get('uri'),
		    'identifier' => \Input::get('identifier'),
		]);
		
		try {
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
                    $page->areas[]= $area;
                }
            }

		    $this->layout = \View::make('w-cms-laravel::back.editorial.pages.edit', [
		        'page' => $page,
                'menus' => \App::make('GetMenusInteractor')->getAll(true),
                'articles' => \App::make('GetArticlesInteractor')->getAll(true),
                'article_categories' => \App::make('GetArticleCategoriesInteractor')->getAll(true),
                'global_blocks' => \App::make('GetBlocksInteractor')->getGlobalBlocks(true),
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