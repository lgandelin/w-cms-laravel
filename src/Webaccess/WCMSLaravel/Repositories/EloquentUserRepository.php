<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Structures\UserStructure;
use CMS\Repositories\UserRepositoryInterface;
use Webaccess\WCMSLaravel\Models\User as UserModel;

class EloquentUserRepository implements UserRepositoryInterface {

    public function findByID($userID)
    {
        $userDB = UserModel::where('id', '=', $userID)->first();

        if ($userDB) {
            $userStructure = new UserStructure();
            $userStructure->ID = $userDB->id;
            $userStructure->login = $userDB->login;
            $userStructure->password = $userDB->password;
            $userStructure->last_name = $userDB->last_name;
            $userStructure->first_name = $userDB->first_name;
            $userStructure->email = $userDB->email;

            return $userStructure;
        }
        return false;
    }

    public function findByLogin($login)
    {
        $userDB = UserModel::where('login', '=', $login)->first();

        if ($userDB) {
            $userStructure = new UserStructure();
            $userStructure->ID = $userDB->id;
            $userStructure->login = $userDB->login;
            $userStructure->password = $userDB->password;
            $userStructure->last_name = $userDB->last_name;
            $userStructure->first_name = $userDB->first_name;
            $userStructure->email = $userDB->email;

            return $userStructure;
        }
        return false;
    }

    public function findAll()
    {
        $usersDB = UserModel::get();

        $users = [];
        foreach ($usersDB as $i => $userDB) {
            $userStructure = new UserStructure();
            $userStructure->ID = $userDB->id;
            $userStructure->login = $userDB->login;
            $userStructure->password = $userDB->password;
            $userStructure->last_name = $userDB->last_name;
            $userStructure->first_name = $userDB->first_name;
            $userStructure->email = $userDB->email;
        
            $users[]= $userStructure;
        }

        return $users;
    }

    public function createUser(UserStructure $userStructure)
    {
        $userDB = new UserModel();
        $userDB->login = $userStructure->login;
        $userDB->password = $userStructure->password;
        $userDB->last_name = $userStructure->last_name;
        $userDB->first_name = $userStructure->first_name;
        $userDB->email = $userStructure->email;

        return $userDB->save();
    }

    public function updateUser($userID, UserStructure $userStructure)
    {
        $userDB = UserModel::where('id', '=', $userID)->first();
        $userDB->login = $userStructure->login;
        if ($userStructure->password)
            $userDB->password = $userStructure->password;
        $userDB->last_name = $userStructure->last_name;
        $userDB->first_name = $userStructure->first_name;
        $userDB->email = $userStructure->email;

        return $userDB->save();
    }

    public function deleteUser($userID)
    {
        $userDB = UserModel::where('id', '=', $userID)->first();
        
        return $userDB->delete();
    }
    
}