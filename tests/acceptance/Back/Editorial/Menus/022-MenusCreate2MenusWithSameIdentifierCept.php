<?php
$I = new WebGuy($scenario);
$I->wantTo('create 2 pages with the same identifier');

//Login
LoginUtils::login($I);
$I->amOnPage(MenusIndexPage::$uri);

//Create the first menu
$I->click(MenusIndexPage::$create_button);
$I->seeCurrentUrlMatches('#(.*)' . MenusCreatePage::$uri . '$#');
$I->seeInTitle(MenusCreatePage::$title);

$I->fillField('Name', MenusCreatePage::$menu_fixture_created['name']);
$I->fillField('Identifier', MenusCreatePage::$menu_fixture_created['identifier']);
$I->click(MenusCreatePage::$submit_button);

//Create the second menu
$I->click(MenusIndexPage::$create_button);
$I->seeCurrentUrlMatches('#(.*)' . MenusCreatePage::$uri . '$#');
$I->seeInTitle(MenusCreatePage::$title);

$I->fillField('Name', MenusCreatePage::$menu_fixture_created['name']);
$I->fillField('Identifier', MenusCreatePage::$menu_fixture_created['identifier']);
$I->click(MenusCreatePage::$submit_button);

//Result
$I->seeCurrentUrlMatches('#(.*)' . MenusCreatePage::$uri_post . '$#');
$I->see(MenusCreatePage::$errorTwoMenusSameIdentifier);