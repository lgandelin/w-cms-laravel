<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Langs\GetLangInteractor;
use Webaccess\WCMSCore\Interactors\Langs\GetLangsInteractor;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        /*$this->beforeFilter(function()
        {
            if (!\Session::has('user')) {
                return \Redirect::to('admin/login');
            }
        }, array('except' => ['login_index', 'login']));*/

        //Global variables
        \View::share('user', \Session::get('user'));
        \View::share('langs', (new GetLangsInteractor())->getAll(true));
        \View::share('editorial_menu_items', Context::get('editorial_menu_items'));

        if (!\Session::has('lang_id')) {
            \Session::put('lang_id', (new GetLangInteractor())->getDefaultLangID());
        }
    }

    public function getLangID()
    {
        return \Session::get('lang_id');
    }
}