<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\BlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\Blocks\ViewFileBlockStructure;
use CMS\Structures\AreaStructure;
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
            $menus = \App::make('GetMenusInteractor')->getAll(true);

            if ($areas) {
                foreach ($areas as $area) {
                    $area->blocks = \App::make('GetBlocksInteractor')->getAll($area->ID, true);
                    $page->areas[]= $area;
                }
            }

		    $this->layout = \View::make('w-cms-laravel::back.editorial.pages.edit', [
		        'page' => $page,
                'menus' => $menus
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
            $areas = \App::make('GetAreasInteractor')->getAll($pageID, true);

            foreach ($areas as $i => $area) {
                $blocks = \App::make('GetBlocksInteractor')->getAll($area->ID, true);

                foreach ($blocks as $j => $block) {
                    \App::make('DeleteBlockInteractor')->run($block->ID);
                }
                \App::make('DeleteAreaInteractor')->run($area->ID);
            }

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
            $newPageID = \App::make('DuplicatePageInteractor')->run($pageID);

            $areas = \App::make('GetAreasInteractor')->getAll($pageID, true);
            foreach ($areas as $i => $area) {

                $areaStructure = new AreaStructure([
                    'name' => $area->name,
                    'width' => $area->width,
                    'height' => $area->height,
                    'class' => $area->class,
                    'order' => $area->order,
                    'page_id' => $newPageID,
                    'display' => $area->display
                ]);

                $newAreaID = \App::make('CreateAreaInteractor')->run($areaStructure);

                $blocks = \App::make('GetBlocksInteractor')->getAll($area->ID, true);
                foreach ($blocks as $j => $block) {

                    $blockStructure = new BlockStructure([
                        'name' => $block->name,
                        'width' => $block->width,
                        'height' => $block->height,
                        'type' => $block->type,
                        'class' => $block->class,
                        'order' => $block->order,
                        'area_id' => $newAreaID,
                        'display' => $block->display
                    ]);

                    $blockID = \App::make('CreateBlockInteractor')->run($blockStructure);

                    if ($block->type == 'html')
                        $blockStructureContent = new HTMLBlockStructure([
                            'html' => $block->html,
                        ]);
                    elseif ($block->type == 'menu')
                        $blockStructureContent = new MenuBlockStructure([
                            'menu_id' => $block->menu_id,
                        ]);
                    elseif ($block->type == 'view_file')
                        $blockStructureContent = new ViewFileBlockStructure([
                            'view_file' => $block->view_file,
                        ]);

                    \App::make('UpdateBlockInteractor')->run($blockID, $blockStructureContent);
                }
            }

            return \Redirect::route('back_pages_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_pages_index');
        }
    }
}