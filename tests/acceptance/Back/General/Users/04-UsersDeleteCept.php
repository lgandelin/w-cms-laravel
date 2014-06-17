<?php
$I = new WebGuy($scenario);
$I->wantTo('delete a user');

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

//Delete the user
$I->click('tr:contains("' . UsersCreatePage::$user_fixture_created['login'] . '") a:nth-child(2)');

//Result
$I->seeCurrentUrlMatches('#(.*)' . UsersIndexPage::$uri . '$#');
$I->seeInTitle(UsersIndexPage::$title);
$I->dontSee(UsersCreatePage::$user_fixture_created['login']);