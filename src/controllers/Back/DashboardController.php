<?php

namespace Webaccess\WCMSLaravel\Back;

use Webaccess\WCMSLaravel\Back\AdminController;

class DashboardController extends AdminController {

    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.index');
    }

    public function login_index()
    {
        $this->layout = \View::make('w-cms-laravel::back.login');
    }

    public function login()
    {
		$credentials = [
            'login' =>  \Input::get('login'),
            'password' =>  \Input::get('password')
        ];

        if (\Input::get('login') && \Auth::attempt($credentials))
            return \Redirect::intended('admin');

        return \Redirect::intended('admin/login');
    }

    public function logout()
    {
        \Auth::logout();
        return \Redirect::intended('admin/login');
    }

}