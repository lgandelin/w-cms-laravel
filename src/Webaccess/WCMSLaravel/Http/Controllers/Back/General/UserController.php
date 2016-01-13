<?php

namespace Webaccess\WCMSLaravel\Http\Controllers\Back\General;

use Illuminate\Support\Facades\Input;
use Webaccess\WCMSCore\Interactors\Users\CreateUserInteractor;
use Webaccess\WCMSCore\Interactors\Users\DeleteUserInteractor;
use Webaccess\WCMSCore\Interactors\Users\GetUserInteractor;
use Webaccess\WCMSCore\Interactors\Users\GetUsersInteractor;
use Webaccess\WCMSCore\Interactors\Users\UpdateUserInteractor;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSLaravel\Http\Controllers\Back\AdminController;

class UserController extends AdminController
{
    public function index()
    {
        return view('w-cms-laravel::back.general.users.index', [
            'users' => (new GetUsersInteractor())->getAll(true),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        return view('w-cms-laravel::back.general.users.create');
    }

    public function store()
    {
        $userStructure = new DataStructure([
            'login' => Input::get('login'),
            'password' => (Input::get('password')) ? sha1(Input::get('password')) : null,
            'last_name' => Input::get('last_name'),
            'first_name' => Input::get('first_name'),
            'email' => Input::get('email'),
        ]);
        
        try {
            $userStructure = (new CreateUserInteractor())->run($userStructure);
            return \Redirect::route('back_users_index');
        } catch (\Exception $e) {
            return view('w-cms-laravel::back.general.users.create', [
                'error' => $e->getMessage(),
                'user' => $userStructure
            ]);
        }
    }

    public function edit($userID)
    {
        try {
            return view('w-cms-laravel::back.general.users.edit', [
                'user' => (new GetUserInteractor())->getUserByID($userID, true)
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_users_index');
        }
    }

    public function update()
    {
        $userID = Input::get('ID');
        $userStructure = new DataStructure([
            'login' => Input::get('login'),
            'password' => (Input::get('password')) ? \Hash::make(Input::get('password')) : null,
            'last_name' => Input::get('last_name'),
            'first_name' => Input::get('first_name'),
            'email' => Input::get('email'),
        ]);

        try {
            (new UpdateUserInteractor())->run($userID, $userStructure);
            return \Redirect::route('back_users_index');
        } catch (\Exception $e) {
            return view('w-cms-laravel::back.general.users.edit', [
                'error' => $e->getMessage(),
                'user' => $userStructure
            ]);
        }
    }

    public function delete($userID)
    {
        try {
            (new DeleteUserInteractor())->run($userID);
            return \Redirect::route('back_users_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_users_index');
        }
    }
}