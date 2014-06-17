<?php
$I = new WebGuy($scenario);
$I->wantTo('view pages list');

//Login
LoginUtils::login($I);
$I->amOnPage(PagesIndexPage::$uri);

//Result
$I->seeInTitle(PagesIndexPage::$title);