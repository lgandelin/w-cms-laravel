<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Structures\MenuStructure;
use CMS\Structures\MenuItemStructure;
use CMS\Repositories\MenuRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Menu as MenuModel;
use Webaccess\WCMSLaravel\Models\MenuItem as MenuItemModel;
use Webaccess\WCMSLaravel\Models\Page as PageModel;

class EloquentMenuRepository implements MenuRepositoryInterface {

    private $pageRepository;

    public function __construct()
    {
        $this->pageRepository = new EloquentPageRepository();
    }

    public function findByID($menuID)
    {
        $menuDB = MenuModel::find($menuID);
        $menuStructure = $this->convertMenuModelToMenuStructure($menuDB);
        if ($menuStructure) {
            foreach ($menuStructure->items as $i => $item) {
                $menuStructure->items[$i]->page =  $this->pageRepository->findByID($item->page_id);
            }
            return $menuStructure;
        }
        return false;
    }

    public function findByIdentifier($identifier)
    {
        $menuDB = MenuModel::where('identifier', '=', $identifier)->first();

        if ($menuDB) {
            $menuStructure = $this->convertMenuModelToMenuStructure($menuDB);
            if ($menuStructure) {
                foreach ($menuStructure->items as $i => $item) {
                    $menuStructure->items[$i]->page =  $this->pageRepository->findByID($item->page_id);
                }
                return $menuStructure;
            }
        }
        return false;
    }

    public function findAll()
    {
        $menusDB = MenuModel::get();

        $menus = [];
        foreach ($menusDB as $i => $menuDB) {
            $menus[]= $this->convertMenuModelToMenuStructure($menuDB);
        }

        return $menus;
    }

    public function createMenu(MenuStructure $menuStructure)
    {
        $menuDB = new MenuModel();
        $menuDB->name = $menuStructure->name;
        $menuDB->identifier = $menuStructure->identifier;

        return $menuDB->save();
    }

    public function updateMenu($menuID, MenuStructure $menuStructure)
    {
        $menuDB = MenuModel::find($menuID);
        $menuDB->name = $menuStructure->name;
        $menuDB->identifier = $menuStructure->identifier;

        return $menuDB->save();
    }

    public function deleteMenu($menuID)
    {
        $menuDB = MenuModel::find($menuID);
        
        return $menuDB->delete();
    }

    public function findItemByID($menuID, $menuItemID)
    {
        if ($menu = $this->findByID($menuID)) {
            if (is_array($menu->items) && sizeof($menu->items) > 0) {
                foreach ($menu->items as $menuItem) {
                    if ($menuItem->ID == $menuItemID)
                        return $menuItem;
                }
            }
        }

        return false;
    }

    public function addItem($menuID, MenuItemStructure $menuItemStructure)
    {
        if ($menu = $this->findByID($menuID)) {
            $menuDB = MenuModel::find($menuID);

            $menuItemDB = new MenuItemModel();
            $menuItemDB->label = $menuItemStructure->label;
            $menuItemDB->order = $menuItemStructure->order;
            $menuItemDB->page_id = $menuItemStructure->page_id;
            $menuItemDB->menu_id = $menuDB->id;

            $result = $menuDB->items()->save($menuItemDB);
            return $result->id;
        }

        return false;
    }

    public function updateItem($menuID, $menuItemID, MenuItemStructure $menuItemStructure)
    {
        if ($menu = $this->findByID($menuID)) {
            $menuDB = MenuModel::find($menuID);

            $menuItemDB = MenuItemModel::find($menuItemID);
            $menuItemDB->label = $menuItemStructure->label;
            $menuItemDB->order = $menuItemStructure->order;
            $menuItemDB->page_id = $menuItemStructure->page_id;

            $menuDB->items()->save($menuItemDB);
        }

        return false;
    }

    public function deleteItem($menuID, $menuItemID)
    {
        if ($menu = $this->findByID($menuID))
            if ($menuItem = $this->findItemByID($menuID, $menuItemID))
                MenuItemModel::find($menuItemID)->delete();
    }

    public function convertMenuModelToMenuStructure(MenuModel $menuModel)
    {
        $menuStructure = new MenuStructure();
        $menuStructure->ID = $menuModel->id;
        $menuStructure->identifier = $menuModel->identifier;
        $menuStructure->name = $menuModel->name;
        $menuStructure->items = [];

        if ($menuModel->items) {
            foreach ($menuModel->items->sortBy('order') as $itemDB) {
                $item = new MenuItemStructure();
                $item->ID = $itemDB->id;
                $item->label = $itemDB->label;
                $item->order = $itemDB->order;
                if ($itemDB->page_id) {
                    $pageDB = PageModel::find($itemDB->page_id);
                    $item->page_id = $pageDB->id;
                }
                $menuStructure->items[]= $item;
            }
        }

        return $menuStructure;
    }

}