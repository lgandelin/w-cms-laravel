<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\BlockStructure;
use CMS\Structures\PageStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class PageController extends AdminController {

	public function index()
	{
		$this->layout = \View::make('w-cms-laravel::back.editorial.pages.index', [
			'pages' => \App::make('GetAllPagesInteractor')->getAll(),
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
		    'text' => \Input::get('text'),
		    'meta_title' => \Input::get('meta_title'),
		    'meta_description' => \Input::get('meta_description'),
		    'meta_keywords' => \Input::get('meta_keywords')
		]);
		
		try {
            $pageStructure = \App::make('CreatePageInteractor')->run($pageStructure);
			return \Redirect::route('back_pages_index');
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
            $page = \App::make('GetPageInteractor')->getByID($pageID);
            $areas = \App::make('GetAllAreasInteractor')->getAll($pageID);
            foreach ($areas as $area) {
                $area->blocks = \App::make('GetAllBlocksInteractor')->getAll($area->ID);
                $page->areas[]= $area;
            }

		    $this->layout = \View::make('w-cms-laravel::back.editorial.pages.edit', [
		        'page' => $page
		    ]);
		} catch (\Exception $e) {
			\Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
		}
	}

    public function delete_area()
    {
        $areaID = \Input::get('ID');

        try {
            \App::make('DeleteAreaInteractor')->run($areaID);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_page_infos()
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

    public function update_page_seo()
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

    public function get_block_infos($blockID)
    {
        try {
            $block = \App::make('GetBlockInteractor')->getByID($blockID);

            return json_encode(array('success' => true, 'block' => $block->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_block_content()
    {
        $blockID = \Input::get('ID');

        $blockStructure = new BlockStructure([
            'html' => \Input::get('html'),
        ]);

        try {
            \App::make('UpdateBlockInteractor')->run($blockID, $blockStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_block_infos()
    {
        $blockID = \Input::get('ID');

        $blockStructure = new BlockStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
            'type' => \Input::get('type'),
            'class' => \Input::get('class'),
        ]);

        try {
            \App::make('UpdateBlockInteractor')->run($blockID, $blockStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function delete_block()
    {
        $blockID = \Input::get('ID');

        try {
            \App::make('DeleteBlockInteractor')->run($blockID);
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