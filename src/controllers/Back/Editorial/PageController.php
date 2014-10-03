<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\BlockStructure;
use CMS\Structures\Blocks\MenuBlockStructure;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\Blocks\ViewFileBlockStructure;
use CMS\Structures\AreaStructure;
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
            $page = \App::make('GetPageInteractor')->getByID($pageID);
            $areas = \App::make('GetAllAreasInteractor')->getAll($pageID);
            $menus = \App::make('GetAllMenusInteractor')->getAll();

            if ($areas) {
                foreach ($areas as $area) {
                    $area->blocks = \App::make('GetAllBlocksInteractor')->getAll($area->ID);
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

    public function get_area_infos($areaID)
    {
        try {
            $area = \App::make('GetAreaInteractor')->getByID($areaID);

            return json_encode(array('success' => true, 'area' => $area->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function create_area()
    {
        $areaStructure = new AreaStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
            'class' => \Input::get('class'),
            'order' => 999,
            'page_id' => \Input::get('page_id'),
        ]);

        try {
            $areaID = \App::make('CreateAreaInteractor')->run($areaStructure);
            $area = \App::make('GetAreaInteractor')->getByID($areaID);

            return json_encode(array('success' => true, 'area' => $area->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }
    
    public function update_area_infos()
    {
        $areaID = \Input::get('ID');

        $areaStructure = new AreaStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
            'class' => \Input::get('class'),
        ]);

        try {
            \App::make('UpdateAreaInteractor')->run($areaID, $areaStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_areas_order()
    {
        $areas = json_decode(\Input::get('areas'));
        for ($i = 0; $i < sizeof($areas); $i++) {
            $areaID = preg_replace('/a-/', '', $areas[$i]);

            $areaStructure = new AreaStructure([
                'order' => $i + 1,
            ]);

            try {
                \App::make('UpdateAreaInteractor')->run($areaID, $areaStructure);
            } catch (\Exception $e) {
                return json_encode(array('success' => false, 'error' => $e->getMessage()));
            }
        }

        return json_encode(array('success' => true));
    }

    public function display_area()
    {
        try {
            $areaID = \Input::get('ID');
            $areaStructure = new AreaStructure([
                'display'=> \Input::get('display')
            ]);

            \App::make('UpdateAreaInteractor')->run($areaID, $areaStructure);
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

    public function create_block()
    {
        $blockStructure = new BlockStructure([
            'name' => \Input::get('name'),
            'width' => \Input::get('width'),
            'height' => \Input::get('height'),
            'type' => \Input::get('type'),
            'class' => \Input::get('class'),
            'order' => 999,
            'area_id' => \Input::get('area_id'),
        ]);

        try {
            $blockID = \App::make('CreateBlockInteractor')->run($blockStructure);
            $block = \App::make('GetBlockInteractor')->getByID($blockID);

            return json_encode(array('success' => true, 'block' => $block->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_block_content()
    {
        $blockID = \Input::get('ID');

        if ($menuID = \Input::get('menu_id'))
            $blockStructure = new MenuBlockStructure([
                'menu_id' => $menuID,
                'type' => 'menu'
            ]);
        elseif ($html = \Input::get('html'))
            $blockStructure = new HTMLBlockStructure([
                'html' => $html,
                'type' => 'html'
            ]);
        elseif ($viewFile = \Input::get('view_file'))
            $blockStructure = new ViewFileBlockStructure([
                'view_file' => $viewFile,
                'type' => 'view_file'
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
            'class' => \Input::get('class')
        ]);

        try {
            \App::make('UpdateBlockInteractor')->run($blockID, $blockStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_blocks_order()
    {
        try {
            $blockID = \Input::get('block_id');
            $blockStructure = new BlockStructure([
                'area_id' => \Input::get('area_id')
            ]);

            \App::make('UpdateBlockInteractor')->run($blockID, $blockStructure);
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }

        $blocks = json_decode(\Input::get('blocks'));
        for ($i = 0; $i < sizeof($blocks); $i++) {
            $blockID = preg_replace('/b-/', '', $blocks[$i]);

            $blockStructure = new BlockStructure([
                'order' => $i + 1,
            ]);

            try {
                \App::make('UpdateBlockInteractor')->run($blockID, $blockStructure);
            } catch (\Exception $e) {
                return json_encode(array('success' => false, 'error' => $e->getMessage()));
            }
        }

        return json_encode(array('success' => true));
    }

    public function display_block()
    {
        try {
            $blockID = \Input::get('ID');
            $blockStructure = new BlockStructure([
                'display'=> \Input::get('display')
            ]);

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
            $areas = \App::make('GetAllAreasInteractor')->getAll($pageID);

            foreach ($areas as $i => $area) {
                $blocks = \App::make('GetAllBlocksInteractor')->getAll($area->ID);

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

            $areas = \App::make('GetAllAreasInteractor')->getAll($pageID);
            foreach ($areas as $i => $area) {

                $areaStructure = new AreaStructure([
                    'name' => $area->name,
                    'width' => $area->width,
                    'height' => $area->height,
                    'class' => $area->class,
                    'order' => $area->order,
                    'page_id' => $newPageID
                ]);

                $newAreaID = \App::make('CreateAreaInteractor')->run($areaStructure);

                $blocks = \App::make('GetAllBlocksInteractor')->getAll($area->ID);
                foreach ($blocks as $j => $block) {

                    $blockStructure = new BlockStructure([
                        'name' => $block->name,
                        'width' => $block->width,
                        'height' => $block->height,
                        'type' => $block->type,
                        'class' => $block->class,
                        'order' => $block->order,
                        'area_id' => $newAreaID
                    ]);

                    $blockID = \App::make('CreateBlockInteractor')->run($blockStructure);

                    $blockStructureContent = new BlockStructure([
                        'html' => $block->html,
                        'menu_id' => $block->menu_id,
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