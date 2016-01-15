<?php
class RoutesCest
{
    public function openPageByRoute(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->seeCurrentUrlEquals('/');
        $I->seeCurrentActionIs('PagesController@getHomepage');
    }
    public function openPageByAction(FunctionalTester $I)
    {
        $I->amOnAction('PagesController@getHomepage');
        $I->seeCurrentUrlEquals('/');
        $I->seeCurrentRouteIs('home');
    }
    public function routesWithTrailingSlashes(FunctionalTester $I)
    {
        $I->amOnPage('/browse/');
        $I->seeCurrentRouteIs('browse');
    }
}
