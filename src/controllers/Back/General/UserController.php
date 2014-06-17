<?php

namespace Webaccess\WCMSLaravel\Back\General;

use Webaccess\WCMSLaravel\Back\AdminController;

class UserController extends AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new \CMS\Services\UserManager(new \Webaccess\WCMSLaravel\Repositories\EloquentUserRepository());
    }

    public function index()
    {
        $this->layout = \View::make('w-cms-laravel::back.general.users.index', [
            'users' => $this->userManager->getAll()
        ]);
    }

    public function create()
    {
        $this->layout = \View::make('w-cms-laravel::back.general.users.create');
    }

    public function store()
    {
        $userS = new \CMS\Structures\UserStructure([
            'login' => \Input::get('login'),
            'password' => (\Input::get('password')) ? \Hash::make(\Input::get('password')) : null,
            'last_name' => \Input::get('last_name'),
            'first_name' => \Input::get('first_name'),
            'email' => \Input::get('email'),
        ]);
        
        try {
            $this->userManager->createUser($userS);
            return \Redirect::route('back_users_index');
        } catch (Exception $e) {
             var_dump($e->getMessage());
        }
    }

    public function edit($login)
    {
        try {
            $userS = $this->userManager->getByLogin($login);
            $this->layout = \View::make('w-cms-laravel::back.general.users.edit', [
                'user' => $userS
            ]);
        } catch (Exception $e) {
             var_dump($e->getMessage());
        }
    }

    public function update()
    {
        $userS = new \CMS\Structures\UserStructure([
            'login' => \Input::get('login'),
            'password' => \Input::get('password'),
            'last_name' => \Input::get('last_name'),
            'first_name' => \Input::get('first_name'),
            'email' => \Input::get('email'),
        ]);

        try {
            $this->userManager->updateUser($userS);
            return \Redirect::route('back_users_index');
        } catch (Exception $e) {
             var_dump($e->getMessage());
        }
    }

    public function delete($login = null)
    {
        try {
            $this->userManager->deleteUser($login);
            return \Redirect::route('back_users_index');
        } catch (Exception $e) {
             var_dump($e->getMessage());
        }
    }

}