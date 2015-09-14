<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\Blocks;

use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\Menus\GetMenusInteractor;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class MenuBlockController extends AdminController
{
    public function getBackView(DataStructure $block)
    {
        return view('w-cms-laravel::back.editorial.pages.blocks.menu', [
            'block' => $block,
            'menus' => (new GetMenusInteractor())->getAll($this->getLangID(), true),
        ])->render();
    }
}
