<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use Webaccess\WCMSCore\Interactors\MenuItems\GetMenuItemsInteractor;
use Webaccess\WCMSCore\Interactors\Menus\CreateMenuInteractor;
use Webaccess\WCMSCore\Interactors\Menus\DeleteMenuInteractor;
use Webaccess\WCMSCore\Interactors\Menus\DuplicateMenuInteractor;
use Webaccess\WCMSCore\Interactors\Menus\GetMenuInteractor;
use Webaccess\WCMSCore\Interactors\Menus\GetMenusInteractor;
use Webaccess\WCMSCore\Interactors\Menus\UpdateMenuInteractor;
use Webaccess\WCMSCore\Interactors\Pages\GetPagesInteractor;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class MenuController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.editorial.menus.index', [
            'menus' => (new GetMenusInteractor())->getAll($this->getLangID(), true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        return view('w-cms-laravel::back.editorial.menus.create');
    }

    public function store()
    {
        $menuStructure = new DataStructure([
            'identifier' => \Input::get('identifier'),
            'name' => \Input::get('name'),
            'lang_id' => $this->getLangID()
        ]);
        
        try {
            $menuID = (new CreateMenuInteractor())->run($menuStructure);
            return \Redirect::route('back_menus_edit', array('menuID' => $menuID));
        } catch (\Exception $e) {
            return view('w-cms-laravel::back.editorial.menus.create', [
                'error' => $e->getMessage(),
                'menu' => $menuStructure
            ]);
        }
    }

    public function edit($menuID)
    {
        try {
            $menu = (new GetMenuInteractor())->getMenuByID($menuID, true);
            $menu->items = (new GetMenuItemsInteractor())->getAll($menuID, true);

            return view('w-cms-laravel::back.editorial.menus.edit', [
                'menu' => $menu,
                'pages' => (new GetPagesInteractor())->getAll($this->getLangID(), true)
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_menus_index');
        }
    }

    public function update()
    {
        $menuID = \Input::get('ID');
        $menuStructure = new DataStructure([
            'name' => \Input::get('name'),
            'identifier' => \Input::get('identifier'),
        ]);

        try {
            (new UpdateMenuInteractor())->run($menuID, $menuStructure);
            return \Redirect::route('back_menus_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_menus_index');
        }
    }

    public function delete($menuID)
    {
        try {
            (new DeleteMenuInteractor())->run($menuID);
            return \Redirect::route('back_menus_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_menus_index');
        }
    }

    public function duplicate($menuID)
    {
        try {
            (new DuplicateMenuInteractor())->run($menuID);
            return \Redirect::route('back_menus_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_menus_index');
        }
    }
}