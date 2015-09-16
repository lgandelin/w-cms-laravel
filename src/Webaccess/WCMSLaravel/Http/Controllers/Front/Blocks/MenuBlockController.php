<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Front\Blocks;

use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\MenuItems\GetMenuItemsInteractor;
use Webaccess\WCMSCore\Interactors\Menus\GetMenuInteractor;
use Webaccess\WCMSCore\Interactors\Pages\GetPageInteractor;

class MenuBlockController
{
    public function index(DataStructure $block)
    {
        if (!$block->menuID) {
            throw new \Exception('Menu not found');
        }

        $menu = (new GetMenuInteractor())->getMenuByID($block->menuID, true);
        $menuItems = (new GetMenuItemsInteractor())->getAll($block->menuID, true);

        foreach ($menuItems as $menuItem)
            if (isset($menuItem->pageID))
                $menuItem->page = (new GetPageInteractor())->getPageByID($menuItem->pageID, true);

        $menu->items = $menuItems;
        $block->menu = $menu;

        return view(\Shortcut::get_theme() . '::blocks.standard.menu', [
            'block' => $block,
        ])->render();
    }
}
