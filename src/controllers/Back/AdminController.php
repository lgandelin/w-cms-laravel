<?php

namespace Webaccess\WCMSLaravel\Back;

class AdminController extends \Illuminate\Routing\Controller {

     public function __construct()
     {
        $this->beforeFilter(function()
        {
            if (\Auth::guest())
                return \Redirect::to('admin/login');
        }, array('except' => ['login_index', 'login']));

        //Global variables
        \View::share('user', \Auth::user());
    }

}