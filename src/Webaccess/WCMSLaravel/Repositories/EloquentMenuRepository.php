<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Repositories\MenuRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Menu as MenuModel;
use Webaccess\WCMSLaravel\Models\MenuItem as MenuItemModel;
use Webaccess\WCMSLaravel\Models\Page as PageModel;

class EloquentMenuRepository implements MenuRepositoryInterface {

    public function findByIdentifier($identifier)
    {
        $menuDB = MenuModel::where('identifier', '=', $identifier)->first();

        if ($menuDB) {
            $menu = new Menu();
            $menu->setIdentifier($menuDB->identifier);

            if ($menuDB->items) {
                foreach ($menuDB->items->sortBy('order') as $itemDB) {
                    $item = new MenuItem();
                    $item->setLabel($itemDB->label);
                    $item->setOrder($itemDB->order);
                    if ($itemDB->page_id) {
                        $page = PageModel::find($itemDB->page_id);
                        $pageRepository = new EloquentPageRepository();
                        $item->setPage($pageRepository->findByIdentifier($page->identifier));
                    }
                    $menu->addItem($item);
                }
            }
            $menu->setName($menuDB->name);

            return $menu;
        }
        return false;
    }

    public function findAll()
    {
        return MenuModel::get();
    }

    public function createMenu(Menu $menu)
    {
        $menuDB = new MenuModel();
        $menuDB->identifier = $menu->getIdentifier();
        $menuDB->name = $menu->getName();

        return $menuDB->save();
    }

    public function updateMenu(Menu $menu)
    {
        $menuDB = MenuModel::where('identifier', '=', $menu->getIdentifier())->first();
        $menuDB->name = $menu->getName();

        //Delete existing items
        MenuItemModel::where('menu_id', '=', $menuDB->id)->delete();
        
        //Add new items
        if (is_array($menu->getItems())) {
            foreach ($menu->getItems() as $item) {
                $itemDB = new MenuItemModel();
                $itemDB->label = $item->getLabel();
                $itemDB->order = $item->getOrder();
                if ($item->getPage()) {
                    $pageDB = PageModel::where('identifier', '=', $item->getPage()->getIdentifier())->first();
                    $itemDB->page_id = $pageDB->id;
                }
                $itemDB->menu_id = $menuDB->id;

                $menuDB->items()->save($itemDB);
            }
        }
        
        return $menuDB->save();
    }

    public function deleteMenu(Menu $menu)
    {
        $menuDB = MenuModel::where('identifier', '=', $menu->getIdentifier())->first();
        
        return $menuDB->delete();
    }
    
}