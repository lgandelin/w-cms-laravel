<?php

class UsersCreatePage
{
    static $uri = '/admin/general/users/create';
    static $uri_post = '/admin/general/users/store';
	static $title = 'Create a user';
    static $submit_button = 'Submit';

    static $errorTwoUsersSameLogin = 'There is already a user with the same login';
    static $errorLoginMandatory = 'You must provide a login for a user';
    
	static $user_fixture_created = array('login' => 'dmartin', 'password' => '111aaa', 'last_name' => 'Martin', 'first_name' => 'Dennis', 'email' => 'dennis.martin@gmail.com');
}