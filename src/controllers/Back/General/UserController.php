<?php

namespace Webaccess\WCMSLaravel\Back\General;

use CMS\Services\UserManager;
use CMS\Structures\UserStructure;
use Webaccess\WCMSLaravel\Back\AdminController;

class UserController extends AdminController {

    public function __construct(UserManager $userManager)
    {
        parent::__construct();
        $this->userManager = $userManager;
    }

    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.general.users.index', [
            'users' => $this->userManager->getAll(),
            'error' => (\Session::has('error')) ? \Session::get('error') : null
        ]);
    }

    public function create()
    {
        $this->layout = \View::make('w-cms-laravel::back.general.users.create');
    }

    public function store()
    {
        $userS = new UserStructure([
            'login' => \Input::get('login'),
            'password' => (\Input::get('password')) ? \Hash::make(\Input::get('password')) : null,
            'last_name' => \Input::get('last_name'),
            'first_name' => \Input::get('first_name'),
            'email' => \Input::get('email'),
        ]);
        
        try {
            $this->userManager->createUser($userS);
            return \Redirect::route('back_users_index');
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.general.users.create', [
                'error' => $e->getMessage(),
                'user' => $userS
            ]);
        }
    }

    public function edit($login)
    {
        try {
            $userS = $this->userManager->getByLogin($login);
            $this->layout = \View::make('w-cms-laravel::back.general.users.edit', [
                'user' => $userS
            ]);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_users_index');
        }
    }

    public function update()
    {
        $userS = new UserStructure([
            'login' => \Input::get('login'),
            'password' => (\Input::get('password')) ? \Hash::make(\Input::get('password')) : null,
            'last_name' => \Input::get('last_name'),
            'first_name' => \Input::get('first_name'),
            'email' => \Input::get('email'),
        ]);

        try {
            $this->userManager->updateUser($userS);
            return \Redirect::route('back_users_index');
        } catch (\Exception $e) {
            $this->layout = \View::make('w-cms-laravel::back.editorial.users.edit', [
                'error' => $e->getMessage(),
                'user' => $userS
            ]);
        }
    }

    public function delete($login = null)
    {
        try {
            $this->userManager->deleteUser($login);
            return \Redirect::route('back_users_index');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return \Redirect::route('back_users_index');
        }
    }

}