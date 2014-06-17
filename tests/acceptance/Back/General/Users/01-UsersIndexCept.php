<?php
$I = new WebGuy($scenario);
$I->wantTo('view users list');

//Login
LoginUtils::login($I);
$I->amOnPage(UsersIndexPage::$uri);

//Result
$I->seeInTitle(UsersIndexPage::$title);