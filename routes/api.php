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

	/*---------------------------------------------------------------------
	 * Frontend Routes (Public routes)
	 --------------------------------------------------------------------*/

Route::group(['namespace' => 'V1','prefix' => 'v1'], function () {
	
	Route::post('registeruser', '\App\Http\Controllers\Api\V1\ApiUserController@postregisterUser');

});

// Route::group(['namespace' => 'V1','prefix' => 'v1/entries', 'middleware' => 'client'], function () {
	
//     Route::get('/all', '\App\Http\Controllers\Api\V1\EntriesController@all');
//     Route::post('/create','\App\Http\Controllers\Api\V1\EntriesController@create');
//     Route::get('{id}', '\App\Http\Controllers\Api\V1\EntriesController@show');
// });

// Route::group(['namespace' => 'V1','prefix' => 'v1/members', 'middleware' => 'client'], function () {
// 	Route::get('{member_id}', '\App\Http\Controllers\Api\V1\MemberController@show');
//     Route::get('/', '\App\Http\Controllers\Api\V1\MemberController@all');
// });


/*-------------------------------------------------------------------------------------------
 * New APis for react app
 *-------------------------------------------------------------------------------------------*/

Route::group(['namespace' => 'V1','prefix' => 'v1', 'middleware' => 'auth:api'], function () {

	/*---------------------------------------------------------------------
	 * Frontend Routes (Routes after authentication)
	 --------------------------------------------------------------------*/

	Route::get('/allcommunities', '\App\Http\Controllers\Api\V1\ApiUserController@getAllCommunities');

	Route::get('/leavecommunity/{community_id}', '\App\Http\Controllers\Api\V1\ApiUserController@leaveCommunity');

	/*---------------------------------------------------------------------
	 * Backend Routes 
	 --------------------------------------------------------------------*/
	 Route::get('/entries/{community_id}', '\App\Http\Controllers\Api\V1\ApiEntriesController@getEntries');
	 Route::post('/entries/{community_id}/create', '\App\Http\Controllers\Api\V1\ApiEntriesController@create');
	 Route::post('/entries/{community_id}/edit', '\App\Http\Controllers\Api\V1\ApiEntriesController@updateEntry');

	 Route::get('/entry/{entry_id}/{community_id}', '\App\Http\Controllers\Api\V1\ApiEntriesController@getSingleEntry');
	

	Route::get('/members/{community_id}', '\App\Http\Controllers\Api\V1\ApiMemberController@getMembers');
	

	// Route::get('/allpermissions/{community_id}', '\App\Http\Controllers\Api\V1\ApiMemberController@getAllMemberPermissions');

	Route::get('/joincommunity/{community_id}', '\App\Http\Controllers\Api\V1\ApiCommunityController@joinCommunity');

	Route::get('/leavecommunity/{community_id}', '\App\Http\Controllers\Api\V1\ApiCommunityController@leaveCommunity');



	Route::get('/assignrole/{user_id}/{role_id}/{community_id}', '\App\Http\Controllers\Api\V1\ApiRoleController@assignRole');

	Route::get('/allroles/{community_id}', '\App\Http\Controllers\Api\V1\ApiRoleController@getRole');
	Route::post('/role/create/{community_id}', '\App\Http\Controllers\Api\V1\ApiRoleController@createRole');
	Route::post('/role/update/{role_id}/{community_id}', '\App\Http\Controllers\Api\V1\ApiRoleController@updateRole');

	Route::get('/role/delete/{id}/{community_id}', '\App\Http\Controllers\Api\V1\ApiRoleController@deleteRole');

});


