<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'api/v1'), function () {

  /*
  |--------------------------------------------------------------------------
  | API Community Routes
  |--------------------------------------------------------------------------
  */
  Route::group(array('prefix' => 'groups'), function () {
    Route::get('{id}/members', '\App\Http\Controllers\Api\CommunitiesController@memberlist');
    Route::get('{id}/entries', '\App\Http\Controllers\Api\CommunitiesController@entrylist');
    Route::get('{id}', '\App\Http\Controllers\Api\CommunitiesController@show');
    Route::get('/', '\App\Http\Controllers\Api\CommunitiesController@all');
  });

  /*
  |--------------------------------------------------------------------------
  | API Member Routes
  |--------------------------------------------------------------------------
  */
  Route::group(array('prefix' => 'members'), function () {
    Route::get('{id}', '\App\Http\Controllers\Api\UsersController@show');
    Route::get('/', '\App\Http\Controllers\Api\UsersController@all');
  });

  /*
  |--------------------------------------------------------------------------
  | API Entry Routes
  |--------------------------------------------------------------------------
  */
  Route::group(array('prefix' => 'entries'), function () {
    Route::get('{id}', '\App\Http\Controllers\Api\EntriesController@show');
    Route::get('/', '\App\Http\Controllers\Api\EntriesController@all');
  });

});


Route::group(['prefix' => LaravelLocalization::setLocale()], function() {

/*
|--------------------------------------------------------------------------
| Authentication and Authorization Routes
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'auth'), function () {

	 # Logout
    Route::get('logout', array(
      'as' => 'logout',
      'uses' => 'Auth\AuthController@getLogout')
    );

    # Login
    Route::get('login', array(
      'as' => 'login',
      'uses' => 'Auth\AuthController@getLogin'));

    Route::post('login', 'Auth\AuthController@postLogin');

    # Register
    Route::get('register', array(
      'as' => 'register',
      'uses' => 'Auth\AuthController@getRegister')
    );

    Route::post('register', 'Auth\AuthController@postRegister');

    # Social
    Route::get('{provider}', 'Auth\AuthController@redirectToProvider');
    Route::get('{provider}/callback', 'Auth\AuthController@handleProviderCallback');


});


/*
|--------------------------------------------------------------------------
| User/Account routes
|--------------------------------------------------------------------------
*/
Route::get('account/history', array(
  'middleware' => 'auth',
  'as' => 'user.history',
  'uses' => 'UserController@getHistory')
);

Route::get('account/settings', array(
  'middleware' => 'auth',
  'as' => 'user.settings.view',
  'uses' => 'UserController@getSettings')
);

Route::post('account/settings', array(
  'middleware' => 'auth',
  'as' => 'user.settings.save',
  'uses' => 'UserController@postSettings')
);

Route::post('account/password', array(
  'middleware' => 'auth',
  'as' => 'user.password.save',
  'uses' => 'UserController@postUpdatePassword')
);

Route::post('account/social', array(
  'middleware' => 'auth',
  'as' => 'user.social.save',
  'uses' => 'UserController@postUpdateSocial')
);

Route::post('account/notification', array(
  'middleware' => 'auth',
  'as' => 'user.notifications.save',
  'uses' => 'UserController@postUpdateNotifications')
);

Route::get('users/{userID}', array(
  'as' => 'user.profile',
  'uses' => 'UserController@getProfile')
);


/*
|--------------------------------------------------------------------------
| Entry routes
|--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'entry'), function () {

  Route::get('new', array(
    'middleware' => 'auth',
    'as' => 'entry.create.form',
    'uses' => 'EntriesController@getCreate')
  );

  Route::post('new', array(
    'middleware' => 'auth',
    'as' => 'entry.create.save',
    'uses' => 'EntriesController@postCreate')
  );

  Route::get('{entryID}/delete', array(
    'middleware' => 'auth',
    'as' => 'entry.delete.save',
    'uses' => 'EntriesController@getDelete')
  );

  Route::get('{entryID}/edit', array(
    'middleware' => 'auth',
    'as' => 'entry.edit.form',
    'uses' => 'EntriesController@getEdit')
  );

  Route::post('{entryID}/edit', array(
    'middleware' => 'auth',
    'as' => 'entry.edit.save',
    'uses' => 'EntriesController@postEdit')
  );

  Route::post('{tileId}/upload', array(
    'middleware' => 'auth',
    'uses' => 'EntriesController@ajaxUpload')
  );

  Route::get('json.browse', array(
    'as' => 'json.browse',
    'uses' => 'EntriesController@getEntriesDataView')
  );

  Route::get('{entryID}', array(
    'as' => 'entry.view',
    'uses' => 'EntriesController@getEntry')
  );

});




/*
|--------------------------------------------------------------------------
| Community routes
|--------------------------------------------------------------------------
*/

Route::get('browse', array(
  'as' => 'browse',
  'uses' => 'CommunitiesController@getEntriesView')
);

Route::get('members', array(
  'as' => 'members',
  'uses' => 'CommunitiesController@getMembers')
);

Route::group(array('prefix' => 'community'), function () {

  Route::get('new', array(
    'middleware' => 'auth',
    'as' => 'community.create.form',
    'uses' => 'CommunitiesController@getCreate')
  );

  Route::post('new', array(
    'middleware' => 'auth',
    'as' => 'community.create.save',
    'uses' => 'CommunitiesController@postCreate')
  );

  Route::get('edit', array(
    'middleware' => 'auth',
    'as' => 'community.edit.form',
    'uses' => 'CommunitiesController@getEdit')
  );

  Route::post('edit',
    [
      'middleware' => 'auth',
      'as' => 'community.edit.save',
      'uses' => 'CommunitiesController@postEdit'
    ]
  );

});






// Stripe Webhook...
Route::post('webhook/stripe', [
  'as' => 'stripe.webhook',
  'uses' => 'StripeWebhookController@handleWebhook' ]
);

/*
|--------------------------------------------------------------------------
| Default homepage stuff
|--------------------------------------------------------------------------
*/

Route::get('terms', function () {
  return view('tos');
});

Route::get('privacy', function () {
  return view('privacy');
});

Route::get('home', function () {
    return redirect('/');
 });


Route::get('/', array(
  'as' => 'home',
  'uses' => 'PagesController@getHomepage'));
});
