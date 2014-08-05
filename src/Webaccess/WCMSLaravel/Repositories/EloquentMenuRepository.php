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

    public function findByIdentifier($identifier)
    {
        $menuDB = MenuModel::where('identifier', '=', $identifier)->first();
        return ($menuDB) ? $this->convertMenuModelToMenuStructure($menuDB) : false;
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
        $menuDB = $this->convertMenuStructureToMenuModel($menuStructure, new MenuModel());
        return $menuDB->save();
    }

    public function updateMenu(MenuStructure $menuStructure)
    {
        $menuDB = MenuModel::where('identifier', '=', $menuStructure->identifier)->first();
        $menuDB = $this->convertMenuStructureToMenuModel($menuStructure, $menuDB);
        
        return $menuDB->save();
    }

    public function deleteMenu(MenuStructure $menuStructure)
    {
        $menuDB = MenuModel::where('identifier', '=', $menuStructure->identifier)->first();
        
        return $menuDB->delete();
    }

    public function convertMenuModelToMenuStructure(MenuModel $menuModel)
    {
        $menuStructure = new MenuStructure();
        $menuStructure->identifier = $menuModel->identifier;
        $menuStructure->name = $menuModel->name;
        $menuStructure->items = [];

        if ($menuModel->items) {
            foreach ($menuModel->items->sortBy('order') as $itemDB) {
                $item = new MenuItemStructure();
                $item->label = $itemDB->label;
                $item->order = $itemDB->order;
                if ($itemDB->page_id) {
                    $page = PageModel::find($itemDB->page_id);
                    $item->page = $page->identifier;
                }
                $menuStructure->items[]= $item;
            }
        }

        return $menuStructure;
    }

    public function convertMenuStructureToMenuModel(MenuStructure $menuStructure, $menuDB)
    {
        $menuDB->name = $menuStructure->name;

        //Delete existing items
        if ($menuDB->id)
            MenuItemModel::where('menu_id', '=', $menuDB->id)->delete();
        else
            $menuDB->identifier = $menuStructure->identifier;
        
        //Add new items
        if (is_array($menuStructure->items)) {
            foreach ($menuStructure->items as $item) {
                $itemDB = new MenuItemModel();
                $itemDB->label = $item->label;
                $itemDB->order = $item->order;
                if ($item->page) {
                    $pageDB = PageModel::where('identifier', '=', $item->page->identifier)->first();
                    $itemDB->page_id = $pageDB->id;
                }
                $itemDB->menu_id = $menuDB->id;

                $menuDB->items()->save($itemDB);
            }
        }

        return $menuDB;
    }
    
}