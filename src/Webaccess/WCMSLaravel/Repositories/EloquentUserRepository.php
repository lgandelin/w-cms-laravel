<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\User;
use CMS\Repositories\UserRepositoryInterface;
use Webaccess\WCMSLaravel\Models\User as UserModel;

class EloquentUserRepository implements UserRepositoryInterface {

    public function findByLogin($login)
    {
        $userDB = UserModel::where('login', '=', $login)->first();

        if ($userDB) {
            $user = new User();
            $user->setLogin($userDB->login);
            $user->setPassword($userDB->password);
            $user->setLastName($userDB->last_name);
            $user->setFirstName($userDB->first_name);
            $user->setEmail($userDB->email);

            return $user;
        }
        return false;
    }

    public function findAll()
    {
        return UserModel::get();
    }

    public function createUser(User $user)
    {
        $userDB = new UserModel();
        $userDB->login = $user->getLogin();
        $userDB->password = $user->getPassword();
        $userDB->last_name = $user->getLastName();
        $userDB->first_name = $user->getFirstName();
        $userDB->email = $user->getEmail();

        return $userDB->save();
    }

    public function updateUser(User $user)
    {
        $userDB = UserModel::where('login', '=', $user->getLogin())->first();
        $userDB->password = $user->getPassword();
        $userDB->last_name = $user->getLastName();
        $userDB->first_name = $user->getFirstName();
        $userDB->email = $user->getEmail();

        return $userDB->save();
    }

    public function deleteUser(User $user)
    {
        $userDB = UserModel::where('login', '=', $user->getLogin())->first();
        
        return $userDB->delete();
    }
    
}