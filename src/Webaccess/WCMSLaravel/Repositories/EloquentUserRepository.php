<?php

namespace Webaccess\WCMSLaravel\Repositories;

use CMS\Entities\User;
use CMS\Repositories\UserRepositoryInterface;
use Webaccess\WCMSLaravel\Models\User as UserModel;

class EloquentUserRepository implements UserRepositoryInterface {

    public function findByID($userID)
    {
        if ($userModel = UserModel::find($userID))
            return self::createUserFromModel($userModel);

        return false;
    }

    public function findByLogin($userLogin)
    {
        if ($userModel = UserModel::where('login', '=', $userLogin)->first())
            return self::createUserFromModel($userModel);

        return false;
    }

    public function findAll()
    {
        $userModels = UserModel::get();

        $users = [];
        foreach ($userModels as $userModel)
            $users[]= self::createUserFromModel($userModel);

        return $users;
    }

    public function createUser(User $user)
    {
        $userModel = new UserModel();
        $userModel->login = $user->getLogin();
        $userModel->password = $user->getPassword();
        $userModel->last_name = $user->getLastName();
        $userModel->first_name = $user->getFirstName();
        $userModel->email = $user->getEmail();

        return $userModel->save();
    }

    public function updateUser(User $user)
    {
        $userModel = UserModel::find($user->getID());
        $userModel->login = $user->getLogin();
        if ($user->getPassword()) $userModel->password = $user->getPassword();
        $userModel->last_name = $user->getLastName();
        $userModel->first_name = $user->getFirstName();
        $userModel->email = $user->getEmail();

        return $userModel->save();
    }

    public function deleteUser($userID)
    {
        $userModel = UserModel::where('id', '=', $userID)->first();
        
        return $userModel->delete();
    }

    private static function createUserFromModel(UserModel $userModel)
    {
        $user = new User();
        $user->setID($userModel->id);
        $user->setLogin($userModel->login);
        $user->setPassword($userModel->password);
        $user->setLastName($userModel->last_name);
        $user->setFirstName($userModel->first_name);
        $user->setEmail($userModel->email);

        return $user;
    }
    
}