<?php

namespace Webaccess\WCMSLaravel\Back\General;

use CMS\Structures\UserStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class UserController extends AdminController {

    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.general.users.index', [
            'users' => \App::make('GetAllUsersInteractor')->getAll(),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        $this->layout = \View::make('w-cms-laravel::back.general.users.create');
    }

    public function store()
    {
        $userStructure = new UserStructure([
            'login' => \Input::get('login'),
            'password' => (\Input::get('password')) ? \Hash::make(\Input::get('password')) : null,
            'last_name' => \Input::get('last_name'),
            'first_name' => \Input::get('first_name'),
            'email' => \Input::get('email'),
        ]);
        
        try {
            $userStructure = \App::make('CreateUserInteractor')->run($userStructure);
            return \Redirect::route('back_users_index');
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.general.users.create', [
                'error' => $e->getMessage(),
                'user' => $userStructure
            ]);
        }
    }

    public function edit($userID)
    {
        try {
            $userStructure = \App::make('GetUserInteractor')->getByID($userID);
            $this->layout = \View::make('w-cms-laravel::back.general.users.edit', [
                'user' => $userStructure
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_users_index');
        }
    }

    public function update()
    {
        $userID = \Input::get('ID');
        $userStructure = new UserStructure([
            'login' => \Input::get('login'),
            'password' => (\Input::get('password')) ? \Hash::make(\Input::get('password')) : null,
            'last_name' => \Input::get('last_name'),
            'first_name' => \Input::get('first_name'),
            'email' => \Input::get('email'),
        ]);

        try {
            \App::make('UpdateUserInteractor')->run($userID, $userStructure);
            return \Redirect::route('back_users_index');
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.general.users.edit', [
                'error' => $e->getMessage(),
                'user' => $userStructure
            ]);
        }
    }

    public function delete($userID)
    {
        try {
            \App::make('DeleteUserInteractor')->run($userID);
            return \Redirect::route('back_users_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_users_index');
        }
    }

}