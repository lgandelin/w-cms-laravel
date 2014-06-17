<?php

class LoginUtils 
{
    public static $username = 'jdoe';
    public static $password = '111aaa';

    public static function login($I)
    {
        $I->amOnPage(LoginPage::$uri);
        $I->fillField('Login', self::$username);
        $I->fillField('Password', self::$password);
        $I->click(LoginPage::$submit_button);
    }

    public static function loginWithParameters($I, $username = '', $password = '')
    {
        $I->amOnPage(LoginPage::$uri);
        $I->fillField('Login', $username);
        $I->fillField('Password', $password);
        $I->click(LoginPage::$submit_button);
    }
}