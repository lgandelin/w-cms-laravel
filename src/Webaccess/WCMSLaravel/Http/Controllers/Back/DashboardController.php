<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back;

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
        \Session::flush();
        return \Redirect::intended('admin/login');
    }
}