<?php
$I = new AcceptanceTester($scenario);

$I->am('Website Visitor');
$I->wantTo('ensure that frontpage loads without errors');
$I->amGoingTo('go to the homepage');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/');
$I->see('AnyShare Society');
