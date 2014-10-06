<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\MenuStructure;
use CMS\Structures\MenuItemStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class MenuController extends AdminController {

    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.editorial.menus.index', [
            'menus' => \App::make('GetMenusInteractor')->getAll(),
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
            $menuStructure = \App::make('GetMenuInteractor')->getByID($menuID);
            $this->layout = \View::make('w-cms-laravel::back.editorial.menus.edit', [
                'menu' => $menuStructure,
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
            $this->layout = \View::make('w-cms-laravel::back.editorial.menus.edit', [
                'error' => $e->getMessage(),
                'menu' => $menuStructure,
                'pages' => \App::make('GetPagesInteractor')->getAll()
            ]);
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
            \App::make('DuplicateMenuInteractor')->run($menuID);
            return \Redirect::route('back_menus_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_menus_index');
        }
    }

    public function add_item()
    {
        $menuID = \Input::get('menuID');
        $menuItemStructure = new MenuItemStructure([
            'label' => \Input::get('label'),
            'order' => (int) \Input::get('order'),
            'page_id' => \Input::get('pageID')
        ]);

        try {
            $id = \App::make('AddMenuItemInteractor')->run($menuID, $menuItemStructure);
            return json_encode(array('success' => true, 'id' => $id));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function delete_item()
    {
        $menuID = \Input::get('menuID');
        $menuItemID = \Input::get('ID');

        try {
            \App::make('DeleteMenuItemInteractor')->run($menuID, $menuItemID);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_item()
    {
        $menuID = \Input::get('menuID');
        $menuItemID = \Input::get('ID');

        $menuItemStructure = new MenuItemStructure([
            'label' => \Input::get('label'),
            'order' => (int) \Input::get('order'),
            'page_id' => \Input::get('pageID')
        ]);

        try {
            \App::make('UpdateMenuItemInteractor')->run($menuID, $menuItemID, $menuItemStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

}