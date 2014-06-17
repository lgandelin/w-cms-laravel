<?php
$I = new WebGuy($scenario);
$I->wantTo('access private interfaces without beeing logged');

$I->amOnPage(EditorialPage::$uri);

//Result
$I->seeCurrentUrlMatches('#(.*)' . LoginPage::$uri . '$#');
$I->seeInTitle(LoginPage::$title);