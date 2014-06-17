<?php
$I = new WebGuy($scenario);
$I->wantTo('view log in page');

$I->amOnPage(LoginPage::$uri);

//Result
$I->seeInTitle(LoginPage::$title);