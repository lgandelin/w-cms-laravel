<?php
$I = new WebGuy($scenario);
$I->wantTo('view menus list');

//Login
LoginUtils::login($I);
$I->amOnPage(MenusIndexPage::$uri);

//Result
$I->seeInTitle(MenusIndexPage::$title);