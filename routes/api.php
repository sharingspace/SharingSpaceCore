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


Route::get('/user', function(Request $request) {
	return response()->json(App\Models\User::all());
	
})->middleware('client');


				


Route::group(['namespace' => 'V1','prefix' => 'v1/entries', 'middleware' => 'client'], function () {
	Route::get('{community_id}/{id}', '\App\Http\Controllers\Api\V1\EntriesController@show');
    Route::get('{community_id}', '\App\Http\Controllers\Api\V1\EntriesController@all');
});

Route::group(['namespace' => 'V1','prefix' => 'v1/members', 'middleware' => 'client'], function () {
	Route::get('{community_id}/{member_id}', '\App\Http\Controllers\Api\V1\MemberController@show');
    Route::get('{community_id}', '\App\Http\Controllers\Api\V1\MemberController@all');
});
