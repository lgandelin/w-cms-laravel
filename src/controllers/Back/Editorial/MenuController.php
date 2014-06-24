<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Services\PageManager;
use CMS\Services\MenuManager;
use CMS\Structures\MenuStructure;
use CMS\Structures\MenuItemStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class MenuController extends AdminController {

    public function __construct(MenuManager $menuManager, PageManager $pageManager)
    {
        parent::__construct();
        $this->menuManager = $menuManager;
        $this->pageManager = $pageManager;
    }

    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.editorial.menus.index', [
            'menus' => $this->menuManager->getAll(),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        $this->layout = \View::make('w-cms-laravel::back.editorial.menus.create');
    }

    public function store()
    {
        $menuS = new MenuStructure([
            'identifier' => \Input::get('identifier'),
            'name' => \Input::get('name'),
        ]);
        
        try {
            $this->menuManager->createMenu($menuS);
            return \Redirect::route('back_menus_index');
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.editorial.menus.create', [
                'error' => $e->getMessage(),
                'menu' => $menuS
            ]);
        }
    }

    public function edit($identifier)
    {
        try {
            $menuS = $this->menuManager->getByIdentifier($identifier);

            $this->layout = \View::make('w-cms-laravel::back.editorial.menus.edit', [
                'menu' => $menuS,
                'pages' => $this->pageManager->getAll()
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_menus_index');
        }
    }

    public function update()
    {
        $items = [];

        $labels = \Input::get('items_label');
        $orders = \Input::get('items_order');
        $pages = \Input::get('items_page');

        if (is_array($labels) && sizeof($labels) > 0) {
            foreach ($labels as $i => $label) {
                if ($labels[$i]) {
                    $items[]= new MenuItemStructure([
                        'label' => $labels[$i],
                        'order' => $orders[$i],
                        'page' => ($pages[$i] ? $pages[$i] : null)
                    ]);
                }
            }    
        }

        $menuS = new MenuStructure([
            'identifier' => \Input::get('identifier'),
            'items' => $items,
            'name' => \Input::get('name'),
        ]);

        try {
            $this->menuManager->updateMenu($menuS);
            return \Redirect::route('back_menus_index');
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.editorial.menus.edit', [
                'error' => $e->getMessage(),
                'menu' => $menuS,
                'pages' => $this->pageManager->getAll()
            ]);
        }
    }

    public function delete($identifier = null)
    {
        try {
            $this->menuManager->deleteMenu($identifier);
            return \Redirect::route('back_menus_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_menus_index');
        }
    }

    public function duplicate($identifier = null)
    {
        try {
            $this->menuManager->duplicateMenu($identifier);
            return \Redirect::route('back_menus_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_menus_index');
        }
    }

}