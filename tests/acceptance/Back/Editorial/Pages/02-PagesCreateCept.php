<?php
$I = new WebGuy($scenario);
$I->wantTo('create a page');

//Login
LoginUtils::login($I);
$I->amOnPage(PagesIndexPage::$uri);

//Create the page
$I->click(PagesIndexPage::$create_button);
$I->seeCurrentUrlMatches('#(.*)' . PagesCreatePage::$uri . '$#');
$I->seeInTitle(PagesCreatePage::$title);

$I->fillField('Name', PagesCreatePage::$page_fixture_created['name']);
$I->fillField('Identifier', PagesCreatePage::$page_fixture_created['identifier']);
$I->fillField('URI', PagesCreatePage::$page_fixture_created['uri']);
$I->fillField('Text', PagesCreatePage::$page_fixture_created['text']);
$I->click(PagesCreatePage::$submit_button);

//Result
$I->seeCurrentUrlMatches('#(.*)' . PagesIndexPage::$uri . '$#');
$I->seeInTitle(PagesIndexPage::$title);
$I->see(PagesCreatePage::$page_fixture_created['name']);
$I->see(PagesCreatePage::$page_fixture_created['identifier']);