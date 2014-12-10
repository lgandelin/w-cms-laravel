<?php

namespace Webaccess\WCMSLaravel\Back\Structure;

use Webaccess\WCMSLaravel\Back\AdminController;

class StructureController extends AdminController
{
    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.structure.index');
    }
}