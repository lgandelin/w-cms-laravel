<?php

namespace Webaccess\WCMSLaravel\Back\Editorial;

use CMS\Structures\MenuItemStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class MenuItemController extends AdminController
{
    public function create()
    {
        $menuItemStructure = new MenuItemStructure([
            'menu_id' => \Input::get('menuID'),
            'label' => \Input::get('label'),
            'order' => (int) \Input::get('order'),
            'page_id' => \Input::get('pageID')
        ]);

        try {
            $id = \App::make('CreateMenuItemInteractor')->run($menuItemStructure);
            return json_encode(array('success' => true, 'id' => $id));
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function update()
    {
        $menuItemID = \Input::get('ID');

        $menuItemStructure = new MenuItemStructure([
            'label' => \Input::get('label'),
            'order' => (int) \Input::get('order'),
            'page_id' => \Input::get('pageID')
        ]);

        try {
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