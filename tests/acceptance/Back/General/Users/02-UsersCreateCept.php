<?php
$I = new WebGuy($scenario);
$I->wantTo('create a user');

//Login
LoginUtils::login($I);
$I->amOnPage(UsersIndexPage::$uri);

//Create the user
$I->click(UsersIndexPage::$create_button);
$I->seeCurrentUrlMatches('#(.*)' . UsersCreatePage::$uri . '$#');
$I->seeInTitle(UsersCreatePage::$title);

$I->fillField('Login', UsersCreatePage::$user_fixture_created['login']);
$I->fillField('Password', UsersCreatePage::$user_fixture_created['password']);
$I->fillField('Last name', UsersCreatePage::$user_fixture_created['last_name']);
$I->fillField('First name', UsersCreatePage::$user_fixture_created['first_name']);
$I->fillField('Email', UsersCreatePage::$user_fixture_created['email']);
$I->click(UsersCreatePage::$submit_button);

//Result
$I->seeCurrentUrlMatches('#(.*)' . UsersIndexPage::$uri . '$#');
$I->seeInTitle(UsersIndexPage::$title);
$I->see(UsersCreatePage::$user_fixture_created['login']);
$I->see(UsersCreatePage::$user_fixture_created['email']);

//Log out
$I->click(DashboardPage::$logout_button);

//Log in with the new user
LoginUtils::loginWithParameters($I, UsersCreatePage::$user_fixture_created['login'], UsersCreatePage::$user_fixture_created['password']);

//Result
$I->seeCurrentUrlMatches('#(.*)' . DashboardPage::$uri . '$#');
$I->seeInTitle(DashboardPage::$title);