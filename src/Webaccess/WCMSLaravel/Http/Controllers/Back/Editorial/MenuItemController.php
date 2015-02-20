<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use CMS\Structures\MenuItemStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class MenuItemController extends AdminController
{
    public function create()
    {
        $menuItemStructure = new MenuItemStructure([
            'menu_id' => \Input::get('menuID'),
            'label' => \Input::get('label'),
            'order' => 999,
            'page_id' => \Input::get('pageID'),
            'class' => \Input::get('class'),
            'display' => 0,
            'external_url' => \Input::get('externalURL'),
        ]);

        try {
            $menuItemID = \App::make('CreateMenuItemInteractor')->run($menuItemStructure);
            $menuItem = \App::make('GetMenuItemInteractor')->getMenuItemByID($menuItemID, true);

            return json_encode(array('success' => true, 'menu_item' => $menuItem->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function get_infos($menuItemID)
    {
        try {
            $menuItem = \App::make('GetMenuItemInteractor')->getMenuItemByID($menuItemID, true);
            return json_encode(array('success' => true, 'menu_item' => $menuItem->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_infos()
    {
        $menuItemID = \Input::get('ID');
        $menuItemStructure = new MenuItemStructure([
            'label' => \Input::get('label'),
            'page_id' => \Input::get('pageID'),
            'class' => \Input::get('class'),
            'external_url' => \Input::get('externalURL'),
        ]);

        try {
            \App::make('UpdateMenuItemInteractor')->run($menuItemID, $menuItemStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_order()
    {
        $menuItems = json_decode(\Input::get('menu_items'));
        for ($i = 0; $i < sizeof($menuItems ); $i++) {
            $menuItemID = preg_replace('/mi-/', '', $menuItems[$i]);
            $menuItemStructure = new MenuItemStructure([
                'order' => $i + 1,
            ]);

            try {
                \App::make('UpdateMenuItemInteractor')->run($menuItemID, $menuItemStructure);
            } catch (\Exception $e) {
                return json_encode(array('success' => false, 'error' => $e->getMessage()));
            }
        }

        return json_encode(array('success' => true));
    }

    public function display()
    {
        try {
            $menuItemID = \Input::get('ID');
            $menuItemStructure = new MenuItemStructure([
                'display'=> \Input::get('display')
            ]);

            \App::make('UpdateMenuItemInteractor')->run($menuItemID, $menuItemStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function delete()
    {
        $menuItemID = \Input::get('ID');

        try {
            \App::make('DeleteMenuItemInteractor')->run($menuItemID);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }
} 