<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Structures\MenuStructure;
use CMS\Structures\MenuItemStructure;
use CMS\Repositories\MenuRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Menu as MenuModel;
use Webaccess\WCMSLaravel\Models\MenuItem as MenuItemModel;

class EloquentMenuRepository implements MenuRepositoryInterface
{
    public function findByID($menuID)
    {
        if ($menuModel = MenuModel::find($menuID))
            return self::createMenuFromModel($menuModel);

        return false;
    }

    public function findByIdentifier($identifier)
    {
        if ($menuModel = MenuModel::where('identifier', '=', $identifier)->first())
            return self::createMenuFromModel($menuModel);

        return false;
    }

    public function findAll()
    {
        $menuModels = MenuModel::get();

        $menus = [];
        foreach ($menuModels as $i => $menuModel) {
            $menus[]= self::createMenuFromModel($menuModel);
        }

        return $menus;
    }

    public function findByMenuID($menuID)
    {
        $menuItemModels = MenuItemModel::where('menu_id', '=', $menuID)->get();

        $menuItems = [];
        foreach ($menuItemModels as $i => $menuItemModel) {
            $menuItems[]= self::createMenuItemFromModel($menuItemModel);
        }

        return $menuItems;
    }

    public function createMenu(Menu $menu)
    {
        $menuModel = new MenuModel();
        $menuModel->name = $menu->getName();
        $menuModel->identifier = $menu->getIdentifier();

        $menuModel->save();

        return $menuModel->id;
    }

    public function updateMenu(Menu $menu)
    {
        $menuModel = MenuModel::find($menu->getID());
        $menuModel->name = $menu->getName();
        $menuModel->identifier = $menu->getIdentifier();

        return $menuModel->save();
    }

    public function deleteMenu($menuID)
    {
        $menuModel = MenuModel::find($menuID);
        
        return $menuModel->delete();
    }




    public function findItemByID($menuItemID)
    {
        if ($menuItemModel = MenuItemModel::find($menuItemID))
            return self::createMenuItemFromModel($menuItemModel);

        return false;
    }

    public function addItem($menuID, MenuItemStructure $menuItemStructure)
    {
        $menuModel = MenuModel::find($menuID);

        $menuItemModel = new MenuItemModel();
        $menuItemModel->label = $menuItemStructure->label;
        $menuItemModel->order = $menuItemStructure->order;
        $menuItemModel->page_id = $menuItemStructure->page_id;
        $menuItemModel->menu_id = $menuModel->id;

        $result = $menuModel->items()->save($menuItemModel);
        return $result->id;
    }

    public function updateItem(MenuItem $menuItem)
    {
        $menuItemModel = MenuItemModel::find($menuItem->getID());
        $menuItemModel->label = $menuItem->getLabel();
        $menuItemModel->order = $menuItem->getOrder();
        $menuItemModel->page_id = $menuItem->getPageID();

        return $menuItemModel->save();
    }

    public function deleteItem($menuItemID)
    {
        $menuItemModel = MenuItemModel::find($menuItemID);

        return $menuItemModel->delete();
    }

    public static function createMenuFromModel(MenuModel $menuModel)
    {
        $menu = new Menu();
        $menu->setID($menuModel->id);
        $menu->setIdentifier($menuModel->identifier);
        $menu->setName($menuModel->name);

        return $menu;
    }
    
    public static function createMenuItemFromModel(MenuItemModel $menuItemModel)
    {
        $menuItem = new MenuItem();
        $menuItem->setID($menuItemModel->id);
        $menuItem->setLabel($menuItemModel->label);
        $menuItem->setOrder($menuItemModel->order);
        $menuItem->setPageID($menuItemModel->page_id);

        return $menuItem;
    }

}