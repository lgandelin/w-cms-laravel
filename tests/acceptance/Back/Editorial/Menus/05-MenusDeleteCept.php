<?php
$I = new WebGuy($scenario);
$I->wantTo('delete a menu');

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

//Delete the menu
$I->click('tr:contains("' . MenusCreatePage::$menu_fixture_created['name'] . '") a:nth-child(3)');

//Result
$I->seeCurrentUrlMatches('#(.*)' . MenusIndexPage::$uri . '$#');
$I->seeInTitle(MenusIndexPage::$title);
$I->dontSee(MenusCreatePage::$menu_fixture_created['name']);