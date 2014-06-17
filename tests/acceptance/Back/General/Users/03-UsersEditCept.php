<?php
$I = new WebGuy($scenario);
$I->wantTo('edit a user');

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

//Edit the user
$I->click('tr:contains("' . UsersCreatePage::$user_fixture_created['login']. '") a:nth-child(1)');
$I->seeCurrentUrlMatches('#(.*)' . UsersEditPage::$uri . '/'. UsersCreatePage::$user_fixture_created['login'] . '$#');
$I->seeInTitle(UsersEditPage::$title);

$I->fillField('First name', UsersEditPage::$user_fixture_edited['first_name']);
$I->click(UsersEditPage::$submit_button);

//Result
$I->seeCurrentUrlMatches('#(.*)' . UsersIndexPage::$uri . '$#');
$I->seeInTitle(UsersIndexPage::$title);
$I->see(UsersCreatePage::$user_fixture_created['last_name'] . ' ' . UsersEditPage::$user_fixture_edited['first_name']);