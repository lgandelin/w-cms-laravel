<?php

namespace Webaccess\WCMSLaravel\Back\General;

use Webaccess\WCMSLaravel\Back\AdminController;

class GeneralController extends AdminController
{
    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.general.index');
    }
}