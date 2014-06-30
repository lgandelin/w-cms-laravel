<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
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

        if ($menuDB) {
            $menu = new Menu();
            $menu->setIdentifier($menuDB->identifier);
            $menu->setName($menuDB->name);

            if ($menuDB->items) {
                foreach ($menuDB->items->sortBy('order') as $itemDB) {
                    $item = new MenuItem();
                    $item->setLabel($itemDB->label);
                    $item->setOrder($itemDB->order);
                    if ($itemDB->page_id) {
                        $page = PageModel::find($itemDB->page_id);
                        $item->setPage($this->pageRepository->findByIdentifier($page->identifier));
                    }
                    $menu->addItem($item);
                }
            }

            return $menu;
        }
        
        return false;
    }

    public function findAll()
    {
        $menusDB = MenuModel::get();

        $menus = [];
        foreach ($menusDB as $i => $menuDB) {
            $menu = new Menu();
            $menu->setIdentifier($menuDB->identifier);
            $menu->setName($menuDB->name);

            foreach ($menuDB->items as $itemDB) {
                $item = new MenuItem();
                $item->setLabel($itemDB->label);
                $item->setOrder($itemDB->order);
                if ($itemDB->page_id) {
                    $page = PageModel::find($itemDB->page_id);
                    $item->setPage($this->pageRepository->findByIdentifier($page->identifier));
                }
                $menu->addItem($item);
            }
        
            $menus[]= $menu;
        }

        return $menus;
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