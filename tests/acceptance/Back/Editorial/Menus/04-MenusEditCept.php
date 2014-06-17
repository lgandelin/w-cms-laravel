<?php
$I = new WebGuy($scenario);
$I->wantTo('edit a menu');

//Login
LoginUtils::login($I);
$I->amOnPage(MenusIndexPage::$uri);

//Create the page
$I->click(MenusIndexPage::$create_button);
$I->seeCurrentUrlMatches('#(.*)' . MenusCreatePage::$uri . '$#');
$I->seeInTitle(MenusCreatePage::$title);

$I->fillField('Name', MenusCreatePage::$menu_fixture_created['name']);
$I->fillField('Identifier', MenusCreatePage::$menu_fixture_created['identifier']);
$I->click(MenusCreatePage::$submit_button);

//Edit the page
$I->click('tr:contains("' . MenusCreatePage::$menu_fixture_created['name']. '") a:nth-child(1)');
$I->seeCurrentUrlMatches('#(.*)' . MenusEditPage::$uri . '/'. MenusCreatePage::$menu_fixture_created['identifier'] . '$#');
$I->seeInTitle(MenusEditPage::$title);

$I->fillField('Name', MenusEditPage::$menu_fixture_edited['name']);
$I->click(MenusEditPage::$submit_button);

//Result
$I->seeCurrentUrlMatches('#(.*)' . MenusIndexPage::$uri . '$#');
$I->seeInTitle(MenusIndexPage::$title);
$I->see(MenusEditPage::$menu_fixture_edited['name']);