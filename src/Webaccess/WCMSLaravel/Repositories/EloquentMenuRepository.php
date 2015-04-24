<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\Menu;
use CMS\Structures\MenuStructure;
use CMS\Repositories\MenuRepositoryInterface;
use Webaccess\WCMSLaravel\Models\Menu as MenuModel;

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

    public function findAll($langID = null)
    {
        $menuModels = MenuModel::get();
        if ($langID) {
            $menuModels = MenuModel::where('lang_id', '=', $langID)->get();
        }

        $menus = [];
        foreach ($menuModels as $menuModel) {
            $menus[]= self::createMenuFromModel($menuModel);
        }

        return $menus;
    }

    public function createMenu(Menu $menu)
    {
        $menuModel = new MenuModel();
        $menuModel->name = $menu->getName();
        $menuModel->identifier = $menu->getIdentifier();
        $menuModel->lang_id = $menu->getLangID();

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

    private static function createMenuFromModel(MenuModel $menuModel)
    {
        $menu = new Menu();
        $menu->setID($menuModel->id);
        $menu->setIdentifier($menuModel->identifier);
        $menu->setLangID($menuModel->lang_id);
        $menu->setName($menuModel->name);

        return $menu;
    }
}