<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('check my main page');
$I->amOnPage('/');
$I->see('Hello world!');

$I->amOnPage('/&lang=ru');
$I->see('Здравствуй мир!');

$I->wantTo('check registration page');
$I->amOnPage('/fVgxeFOmzj');
$I->fillField('login', 'codeception');
$I->fillField('password', 'AcceptanceTester1');
$I->selectOption('role', 'Customer');
$I->click('#SendBtn');
$I->see('Hello world!');

$I->wantTo('check my authorization form');
$I->amOnPage('/');
$I->fillField('User', 'codeception');
$I->fillField('Password', 'AcceptanceTester1');
$I->click('#SubmitBtn');
$I->see('codeception');

$I->wantTo('check account page');
$I->amOnPage('/KO5Uw2Xxj5');
$I->see('general');
$I->fillField('message', 'test forum');
$I->click('#SubmitBtn');
$I->see('test forum');

$I->click('test forum');
$I->fillField('message', 'test theme');
$I->click('#SubmitBtn');
$I->see('test theme');

$I->click('test theme');
$I->fillField('message', 'test topic');
$I->click('#SubmitBtn');
$I->see('test topic');
?>