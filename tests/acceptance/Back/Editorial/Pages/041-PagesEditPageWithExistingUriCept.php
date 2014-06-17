<?php
$I = new WebGuy($scenario);
$I->wantTo('edit a page with an existing URI');

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


//Create another page
$I->click(PagesIndexPage::$create_button);
$I->seeCurrentUrlMatches('#(.*)' . PagesCreatePage::$uri . '$#');
$I->seeInTitle(PagesCreatePage::$title);

$I->fillField('Name', PagesCreatePage::$page_fixture_created['name'] . ' - COPY');
$I->fillField('Identifier', PagesCreatePage::$page_fixture_created['identifier'] . '-copy');
$I->fillField('URI', PagesCreatePage::$page_fixture_created['uri'] . '-copy');
$I->fillField('Text', PagesCreatePage::$page_fixture_created['text']);
$I->click(PagesCreatePage::$submit_button);

//Edit the page
$I->click('tr:contains("' . PagesCreatePage::$page_fixture_created['name']. ' - COPY") a:nth-child(1)');

$I->fillField('URI', PagesCreatePage::$page_fixture_created['uri']);
$I->click(PagesEditPage::$submit_button);

//Result
$I->seeCurrentUrlMatches('#(.*)' . PagesEditPage::$uri_post . '$#');
$I->see(PagesCreatePage::$errorTwoPagesSameUri);