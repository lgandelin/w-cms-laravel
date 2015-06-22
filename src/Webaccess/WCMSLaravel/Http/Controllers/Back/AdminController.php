<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back;

use CMS\Interactors\Langs\GetLangInteractor;
use CMS\Interactors\Langs\GetLangsInteractor;
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
        \View::share('langs', (new GetLangsInteractor())->getAll(true));
        \View::share('editorial_menu_items', \App::make('AdminMenu')->getItems());

        if (!\Session::has('lang_id')) {
            \Session::put('lang_id', (new GetLangInteractor())->getDefaultLangID());
        }
    }

    public function getLangID()
    {
        return \Session::get('lang_id');
    }
}