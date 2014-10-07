<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\MenuStructure;
use CMS\Structures\MenuItemStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class MenuController extends AdminController
{
    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.editorial.menus.index', [
            'menus' => \App::make('GetMenusInteractor')->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        $this->layout = \View::make('w-cms-laravel::back.editorial.menus.create');
    }

    public function store()
    {
        $menuStructure = new MenuStructure([
            'identifier' => \Input::get('identifier'),
            'name' => \Input::get('name'),
        ]);
        
        try {
            $menuID = \App::make('CreateMenuInteractor')->run($menuStructure);
            return \Redirect::route('back_menus_edit', array('menuID' => $menuID));
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.editorial.menus.create', [
                'error' => $e->getMessage(),
                'menu' => $menuStructure
            ]);
        }
    }

    public function edit($menuID)
    {
        try {
            $menu = \App::make('GetMenuInteractor')->getMenuByID($menuID, true);
            $menu->items = \App::make('GetMenuItemsInteractor')->getAll($menuID, true);

            $this->layout = \View::make('w-cms-laravel::back.editorial.menus.edit', [
                'menu' => $menu,
                'pages' => \App::make('GetPagesInteractor')->getAll(true)
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_menus_index');
        }
    }

    public function update()
    {
        $menuID = \Input::get('ID');
        $menuStructure = new MenuStructure([
            'name' => \Input::get('name'),
            'identifier' => \Input::get('identifier'),
        ]);

        try {
            \App::make('UpdateMenuInteractor')->run($menuID, $menuStructure);
            return \Redirect::route('back_menus_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_menus_index');
        }
    }

    public function delete($menuID)
    {
        try {
            \App::make('DeleteMenuInteractor')->run($menuID);
            return \Redirect::route('back_menus_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_menus_index');
        }
    }

    public function duplicate($menuID)
    {
        try {
            $newMenuID = \App::make('DuplicateMenuInteractor')->run($menuID);

            $menuItems = \App::make('GetMenuItemsInteractor')->getAll($menuID, true);
            foreach ($menuItems as $menuItem) {
                $menuItemStructure = new MenuItemStructure([
                    'menu_id' => $newMenuID,
                    'label' => $menuItem->label,
                    'order' => $menuItem->order,
                    'page_id' => $menuItem->page_id,
                    'class' => $menuItem->class,
                    'display' => $menuItem->display,
                    'external_url' => $menuItem->external_url,
                ]);

                \App::make('CreateMenuItemInteractor')->run($menuItemStructure);
            }

            return \Redirect::route('back_menus_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_menus_index');
        }
    }
}