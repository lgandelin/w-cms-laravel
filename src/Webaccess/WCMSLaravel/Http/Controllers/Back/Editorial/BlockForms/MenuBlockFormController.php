<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\BlockForms;

use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Menus\GetMenusInteractor;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class MenuBlockFormController extends AdminController
{
    public function getForm(DataStructure $block)
    {
        return view('w-cms-laravel::back.editorial.pages.blocks.menu', [
            'block' => $block,
            'menus' => (new GetMenusInteractor())->getAll($this->getLangID(), true),
        ])->render();
    }
}
