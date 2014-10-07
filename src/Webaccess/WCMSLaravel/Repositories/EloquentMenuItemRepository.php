<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\MenuItem;
use CMS\Repositories\MenuItemRepositoryInterface;
use CMS\Structures\MenuItemStructure;
use Webaccess\WCMSLaravel\Models\MenuItem as MenuItemModel;

class EloquentMenuItemRepository implements MenuItemRepositoryInterface
{
    public function findByID($menuItemID)
    {
        if ($menuItemModel = MenuItemModel::find($menuItemID))
            return self::createMenuItemFromModel($menuItemModel);

        return false;
    }

    public function findByMenuID($menuID)
    {
        $menuItemModels = MenuItemModel::where('menu_id', '=', $menuID)->orderBy('order', 'asc')->get();

        $menuItems = [];
        foreach ($menuItemModels as $i => $menuItemModel) {
            $menuItems[]= self::createMenuItemFromModel($menuItemModel);
        }

        return $menuItems;
    }

    public function createMenuItem(MenuItem $menuItem)
    {
        $menuItemModel = new MenuItemModel();
        $menuItemModel->label = $menuItem->getLabel();
        $menuItemModel->order = $menuItem->getOrder();
        $menuItemModel->page_id = $menuItem->getPageID();
        $menuItemModel->menu_id = $menuItem->getMenuID();

        $menuItemModel->save();

        return $menuItemModel->id;
    }

    public function updateMenuItem(MenuItem $menuItem)
    {
        $menuItemModel = MenuItemModel::find($menuItem->getID());
        $menuItemModel->label = $menuItem->getLabel();
        $menuItemModel->order = $menuItem->getOrder();
        $menuItemModel->page_id = $menuItem->getPageID();

        return $menuItemModel->save();
    }

    public function deleteMenuItem($menuItemID)
    {
        $menuItemModel = MenuItemModel::find($menuItemID);

        return $menuItemModel->delete();
    }

    private static function createMenuItemFromModel(MenuItemModel $menuItemModel)
    {
        $menuItem = new MenuItem();
        $menuItem->setID($menuItemModel->id);
        $menuItem->setLabel($menuItemModel->label);
        $menuItem->setOrder($menuItemModel->order);
        $menuItem->setPageID($menuItemModel->page_id);

        return $menuItem;
    }
} 