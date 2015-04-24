<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\Structure;

use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class StructureController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.structure.index');
    }
}