<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back;

use Illuminate\Support\Facades\Input;
use Webaccess\WCMSCore\Interactors\Users\GetUserInteractor;
use Webaccess\WCMSCore\Interactors\Users\LoginUserInteractor;

class DashboardController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.index');
    }

    public function login_index()
    {
        return view('w-cms-laravel::back.login');
    }

    public function login()
    {
        $login = Input::get('login');
        $password = Input::get('password');

        try {
            if ((new LoginUserInteractor())->run($login, $password)) {
                \Session::put('user', (new GetUserInteractor())->getUserByLogin($login, true));

                return \Redirect::intended('admin');
            }
        } catch(\Exception $e) {

        }

        return \Redirect::intended('admin/login');
    }

    public function logout()
    {
        \Auth::logout();
        \Session::flush();
        return \Redirect::intended('admin/login');
    }
}