<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\User;
use CMS\Repositories\UserRepositoryInterface;
use Webaccess\WCMSLaravel\Models\User as UserModel;

class EloquentUserRepository implements UserRepositoryInterface {

    public function findByID($userID)
    {
        $userDB = UserModel::find($userID);

        if ($userDB) {
            $user = new User();
            $user->setID($userDB->id);
            $user->setLogin($userDB->login);
            $user->setPassword($userDB->password);
            $user->setLastName($userDB->last_name);
            $user->setFirstName($userDB->first_name);
            $user->setEmail($userDB->email);

            return $user;
        }

        return false;
    }

    public function findByLogin($userLogin)
    {
        $userDB = UserModel::where('login', '=', $userLogin)->first();

        if ($userDB) {
            $user = new User();
            $user->setID($userDB->id);
            $user->setLogin($userDB->login);
            $user->setPassword($userDB->password);
            $user->setLastName($userDB->last_name);
            $user->setFirstName($userDB->first_name);
            $user->setEmail($userDB->email);

            return $user;
        }
    }

    public function findAll()
    {
        $usersDB = UserModel::get();

        $users = [];
        foreach ($usersDB as $i => $userDB) {
            $user = new User();
            $user->setID($userDB->id);
            $user->setLogin($userDB->login);
            $user->setPassword($userDB->password);
            $user->setLastName($userDB->last_name);
            $user->setFirstName($userDB->first_name);
            $user->setEmail($userDB->email);

            $users[]= $user;
        }

        return $users;
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
        $userDB = UserModel::find($user->getID());
        $userDB->login = $user->getLogin();
        if ($user->getPassword()) $userDB->password = $user->getPassword();
        $userDB->last_name = $user->getLastName();
        $userDB->first_name = $user->getFirstName();
        $userDB->email = $user->getEmail();

        return $userDB->save();
    }

    public function deleteUser($userID)
    {
        $userDB = UserModel::where('id', '=', $userID)->first();
        
        return $userDB->delete();
    }
    
}