<?php
$I = new WebGuy($scenario);
$I->wantTo('create a user without login');

//Login
LoginUtils::login($I);
$I->amOnPage(UsersIndexPage::$uri);

//Create the user
$I->click(UsersIndexPage::$create_button);
$I->seeCurrentUrlMatches('#(.*)' . UsersCreatePage::$uri . '$#');
$I->seeInTitle(UsersCreatePage::$title);

$I->fillField('Password', UsersCreatePage::$user_fixture_created['password']);
$I->fillField('Last name', UsersCreatePage::$user_fixture_created['last_name']);
$I->fillField('First name', UsersCreatePage::$user_fixture_created['first_name']);
$I->fillField('Email', UsersCreatePage::$user_fixture_created['email']);
$I->click(UsersCreatePage::$submit_button);

//Result
$I->seeCurrentUrlMatches('#(.*)' . UsersCreatePage::$uri_post . '$#');
$I->see(UsersCreatePage::$errorLoginMandatory);