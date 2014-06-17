+<?php
$I = new WebGuy($scenario);
$I->wantTo('create a menu');

//Login
LoginUtils::login($I);
$I->amOnPage(MenusIndexPage::$uri);

//Create the menu
$I->click(MenusIndexPage::$create_button);
$I->seeCurrentUrlMatches('#(.*)' . MenusCreatePage::$uri . '$#');
$I->seeInTitle(MenusCreatePage::$title);

$I->fillField('Name', MenusCreatePage::$menu_fixture_created['name']);
$I->fillField('Identifier', MenusCreatePage::$menu_fixture_created['identifier']);
$I->click(MenusCreatePage::$submit_button);

//Result
$I->seeCurrentUrlMatches('#(.*)' . MenusIndexPage::$uri . '$#');
$I->seeInTitle(MenusIndexPage::$title);
$I->see(MenusCreatePage::$menu_fixture_created['name']);
$I->see(MenusCreatePage::$menu_fixture_created['identifier']);