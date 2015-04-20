<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back;

use Illuminate\Routing\Controller;

class AdminController extends Controller
{
     public function __construct()
     {
        $this->beforeFilter(function()
        {
            if (\Auth::guest())
                return \Redirect::to('admin/login');
        }, array('except' => ['login_index', 'login']));

        //Global variables
        \View::share('user', \Auth::user());
        \View::share('langs', \App::make('GetLangsInteractor')->getAll(true));
    }

    public function getLangID()
    {
        return \Session::get('lang_id');
    }
}