<?php

namespace Webaccess\WCMSLaravel\Back\General;

class GeneralController extends \Illuminate\Routing\Controller {

    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.general.index');
    }
}