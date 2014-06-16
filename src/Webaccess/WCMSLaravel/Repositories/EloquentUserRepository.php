<?php

namespace Webaccess\WCMSLaravel\Repositories;

class EloquentUserRepository implements \CMS\Repositories\UserRepositoryInterface {

    public function findByLogin($login)
    {
        $userDB = \Webaccess\WCMSLaravel\Models\User::where('login', '=', $login)->first();

        if ($userDB) {
            $user = new \CMS\Entities\User();
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
        return \Webaccess\WCMSLaravel\Models\User::get();
    }

    public function createUser(\CMS\Entities\User $user)
    {
        $userDB = new \Webaccess\WCMSLaravel\Models\User();
        $userDB->login = $user->getLogin();
        $userDB->password = $user->getPassword();
        $userDB->last_name = $user->getLastName();
        $userDB->first_name = $user->getFirstName();
        $userDB->email = $user->getEmail();

        return $userDB->save();
    }

    public function updateUser(\CMS\Entities\User $user)
    {
        $userDB = \Webaccess\WCMSLaravel\Models\User::where('login', '=', $user->getLogin())->first();
        $userDB->password = $user->getPassword();
        $userDB->last_name = $user->getLastName();
        $userDB->first_name = $user->getFirstName();
        $userDB->email = $user->getEmail();

        return $userDB->save();
    }

    public function deleteUser(\CMS\Entities\User $user)
    {
        $userDB = \Webaccess\WCMSLaravel\Models\User::where('login', '=', $user->getLogin())->first();
        
        return $userDB->delete();
    }
}