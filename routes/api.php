	<?php

	use Illuminate\Http\Request;

	/*
	|--------------------------------------------------------------------------
	| API Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register API routes for your application. These
	| routes are loaded by the RouteServiceProvider within a group which
	| is assigned the "api" middleware group. Enjoy building your API!
	|
	*/

Route::group(['namespace' => 'V1','prefix' => 'v1/entries', 'middleware' => 'client'], function () {
	
    Route::get('/all', '\App\Http\Controllers\Api\V1\EntriesController@all');
    Route::post('/create','\App\Http\Controllers\Api\V1\EntriesController@create');
    Route::get('{id}', '\App\Http\Controllers\Api\V1\EntriesController@show');
});

Route::group(['namespace' => 'V1','prefix' => 'v1/members', 'middleware' => 'client'], function () {
	Route::get('{member_id}', '\App\Http\Controllers\Api\V1\MemberController@show');
    Route::get('/', '\App\Http\Controllers\Api\V1\MemberController@all');
});


/*-------------------------------------------------------------------------------------------------
 * New APis for react app
 *-------------------------------------------------------------------------------------------------/

/*
 * Get all sharing spaces
 */

Route::group(['namespace' => 'V1','prefix' => 'v1/spaces', 'middleware' => 'auth:api'], function () {
	Route::get('/allcommunities', '\App\Http\Controllers\Api\V1\SharingController@getAllCommunities');
	Route::get('/allpermissions/{community_id}', '\App\Http\Controllers\Api\V1\SharingController@getAllUserPermissions');
	Route::get('/members/{community_id}', '\App\Http\Controllers\Api\V1\SharingController@getMembers');
	Route::get('/entries/{community_id}', '\App\Http\Controllers\Api\V1\SharingController@getEntries');
});


