<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\General;

use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class GeneralController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.general.index');
    }
}