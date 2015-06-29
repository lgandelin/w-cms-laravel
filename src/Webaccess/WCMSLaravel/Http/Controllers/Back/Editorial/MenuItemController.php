<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial;

use CMS\Interactors\MenuItems\CreateMenuItemInteractor;
use CMS\Interactors\MenuItems\DeleteMenuItemInteractor;
use CMS\Interactors\MenuItems\GetMenuItemInteractor;
use CMS\Interactors\MenuItems\UpdateMenuItemInteractor;
use CMS\DataStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class MenuItemController extends AdminController
{
    public function create()
    {
        $menuItemStructure = new DataStructure([
            'menu_id' => \Input::get('menuID'),
            'label' => \Input::get('label'),
            'order' => 999,
            'page_id' => \Input::get('pageID'),
            'class' => \Input::get('class'),
            'display' => 0,
            'external_url' => \Input::get('externalURL'),
        ]);

        try {
            $menuItemID = (new CreateMenuItemInteractor())->run($menuItemStructure);
            $menuItem = (new GetMenuItemInteractor())->getMenuItemByID($menuItemID, true);

            return json_encode(array('success' => true, 'menu_item' => $menuItem->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function get_infos($menuItemID)
    {
        try {
            $menuItem = (new GetMenuItemInteractor())->getMenuItemByID($menuItemID, true);
            return json_encode(array('success' => true, 'menu_item' => $menuItem->toArray()));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update_infos()
    {
        $menuItemID = \Input::get('ID');
        $menuItemStructure = new DataStructure([
            'label' => \Input::get('label'),
            'page_id' => \Input::get('pageID'),
            'class' => \Input::get('class'),
            'external_url' => \Input::get('externalURL'),
        ]);

        try {
            (new UpdateMenuItemInteractor())->run($menuItemID, $menuItemStructure);
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
            $menuItemStructure = new DataStructure([
                'order' => $i + 1,
            ]);

            try {
                (new UpdateMenuItemInteractor())->run($menuItemID, $menuItemStructure);
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
            $menuItemStructure = new DataStructure([
                'display'=> \Input::get('display')
            ]);

            (new UpdateMenuItemInteractor())->run($menuItemID, $menuItemStructure);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function delete()
    {
        $menuItemID = \Input::get('ID');

        try {
            (new DeleteMenuItemInteractor())->run($menuItemID);
            return json_encode(array('success' => true));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }
} 