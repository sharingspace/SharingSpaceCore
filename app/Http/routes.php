<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Authentication and Authorization Routes
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'auth'), function () {

    # Email required
    Route::get('email-required', array('as' => 'email-required', 'uses' => 'Auth\AuthController@getUpdateEmail'));
    Route::post('email-required', array('as' => 'email-required', 'uses' => 'Auth\AuthController@postUpdateEmail'));

	# Logout
    Route::get('logout', array('as' => 'logout', 'uses' => 'Auth\AuthController@getLogout'));

    # Login
    Route::get('login', array('as' => 'login', 'uses' => 'Auth\AuthController@getLogin'));
    Route::post('login', 'Auth\AuthController@postLogin');

    # Register
    Route::get('register', array('as' => 'register', 'uses' => 'Auth\AuthController@getRegister'));
    Route::post('register', 'Auth\AuthController@postRegister');

    # Social
    Route::get('{provider}', 'Auth\AuthController@redirectToProvider');
    Route::get('{provider}/callback', 'Auth\AuthController@handleProviderCallback');


});



Route::get('home', function () {
    return redirect('/');
 });


Route::get('/', array('as' => 'home', 'uses' => 'PagesController@getHomepage'));
