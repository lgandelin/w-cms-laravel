<?php
$I = new WebGuy($scenario);
$I->wantTo('log in with invalid credentials');

//Login
$I->amOnPage(LoginPage::$uri); 
LoginUtils::loginWithParameters($I, 'invalid_username', 'invalid_password');

//Result
$I->seeCurrentUrlMatches('#(.*)' . LoginPage::$uri . '$#');
$I->seeInTitle(LoginPage::$title);