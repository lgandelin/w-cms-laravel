<?php

namespace Webaccess\WCMSLaravel\Repositories;

class EloquentMenuRepository implements \CMS\Repositories\MenuRepositoryInterface {

    public function findByIdentifier($identifier)
    {
        $menuDB = \Webaccess\WCMSLaravel\Models\Menu::where('identifier', '=', $identifier)->first();

        if ($menuDB) {
            $menu = new \CMS\Entities\Menu();
            $menu->setIdentifier($menuDB->identifier);

            if ($menuDB->items) {
                foreach ($menuDB->items->sortBy('order') as $itemDB) {
                    $item = new \CMS\Entities\MenuItem();
                    $item->setLabel($itemDB->label);
                    $item->setOrder($itemDB->order);
                    if ($itemDB->page_id) {
                        $page = \Webaccess\WCMSLaravel\Models\Page::find($itemDB->page_id);
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
        return \Webaccess\WCMSLaravel\Models\Menu::get();
    }

    public function createMenu(\CMS\Entities\Menu $menu)
    {
        $menuDB = new \Webaccess\WCMSLaravel\Models\Menu();
        $menuDB->identifier = $menu->getIdentifier();
        //$menuDB->items = $menu->getItems();
        $menuDB->name = $menu->getName();

        return $menuDB->save();
    }

    public function updateMenu(\CMS\Entities\Menu $menu)
    {
        $menuDB = \Webaccess\WCMSLaravel\Models\Menu::where('identifier', '=', $menu->getIdentifier())->first();
        $menuDB->name = $menu->getName();

        //Delete existing items
        \Webaccess\WCMSLaravel\Models\MenuItem::where('menu_id', '=', $menuDB->id)->delete();
        
        //Add new items
        if (is_array($menu->getItems())) {
            foreach ($menu->getItems() as $item) {
                $itemDB = new \Webaccess\WCMSLaravel\Models\MenuItem();
                $itemDB->label = $item->getLabel();
                $itemDB->order = $item->getOrder();
                if ($item->getPage()) {
                    $pageDB = \Webaccess\WCMSLaravel\Models\Page::where('identifier', '=', $item->getPage()->getIdentifier())->first();
                    $itemDB->page_id = $pageDB->id;
                }
                $itemDB->menu_id = $menuDB->id;

                $menuDB->items()->save($itemDB);
            }
        }
        
        return $menuDB->save();
    }

    public function deleteMenu(\CMS\Entities\Menu $menu)
    {
        $menuDB = \Webaccess\WCMSLaravel\Models\Menu::where('identifier', '=', $menu->getIdentifier())->first();
        
        return $menuDB->delete();
    }
}