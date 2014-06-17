<?php
$I = new WebGuy($scenario);
$I->wantTo('log in with correct credentials');

//Login
LoginUtils::login($I);

//Result
$I->seeCurrentUrlMatches('#(.*)' . DashboardPage::$uri . '$#');
$I->seeInTitle(DashboardPage::$title);