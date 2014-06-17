<?php
$I = new WebGuy($scenario);
$I->wantTo('create a menu without identifier');

//Login
LoginUtils::login($I);
$I->amOnPage(MenusIndexPage::$uri);

//Create the page
$I->click(MenusIndexPage::$create_button);
$I->seeCurrentUrlMatches('#(.*)' . MenusCreatePage::$uri . '$#');
$I->seeInTitle(MenusCreatePage::$title);

$I->fillField('Name', MenusCreatePage::$menu_fixture_created['name']);
$I->click(MenusCreatePage::$submit_button);

//Result
$I->seeCurrentUrlMatches('#(.*)' . MenusCreatePage::$uri_post . '$#');
$I->see(MenusCreatePage::$errorIdentifierMandatory);