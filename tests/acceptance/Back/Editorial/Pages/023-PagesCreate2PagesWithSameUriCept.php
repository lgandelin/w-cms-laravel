<?php
$I = new WebGuy($scenario);
$I->wantTo('create 2 pages with the same URI');

//Login
LoginUtils::login($I);
$I->amOnPage(PagesIndexPage::$uri);

//Create the first page
$I->click(PagesIndexPage::$create_button);
$I->seeCurrentUrlMatches('#(.*)' . PagesCreatePage::$uri . '$#');
$I->seeInTitle(PagesCreatePage::$title);

$I->fillField('Name', PagesCreatePage::$page_fixture_created['name']);
$I->fillField('Identifier', PagesCreatePage::$page_fixture_created['identifier']);
$I->fillField('URI', PagesCreatePage::$page_fixture_created['uri']);
$I->fillField('Text', PagesCreatePage::$page_fixture_created['text']);
$I->click(PagesCreatePage::$submit_button);

//Create the second page
$I->click(PagesIndexPage::$create_button);
$I->seeCurrentUrlMatches('#(.*)' . PagesCreatePage::$uri . '$#');
$I->seeInTitle(PagesCreatePage::$title);

$I->fillField('Name', PagesCreatePage::$page_fixture_created['name']);
$I->fillField('Identifier', PagesCreatePage::$page_fixture_created['identifier'] . ' COPY');
$I->fillField('URI', PagesCreatePage::$page_fixture_created['uri']);
$I->fillField('Text', PagesCreatePage::$page_fixture_created['text']);
$I->click(PagesCreatePage::$submit_button);

//Result
$I->seeCurrentUrlMatches('#(.*)' . PagesCreatePage::$uri_post . '$#');
$I->see(PagesCreatePage::$errorTwoPagesSameUri);