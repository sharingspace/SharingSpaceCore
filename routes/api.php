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


	Route::get('/test', function (Request $request) {
		
	    $guzzle = new GuzzleHttp\Client;
		
		$response = $guzzle->post(url('oauth/token'), 

			[
				'json' => [
					'grant_type' => 'client_credentials',
					'client_id' => '1',
					'client_secret' => 'VyKxL4nctfS34XquLyk8hgZVK1khm1xBM2azxNwK',
		    ],
		]);
		
		return json_decode((string)$response->getBody(), true);
	});


	Route::get('/user', function(Request $request) {
		return response()->json(App\Models\User::all());
		
	})->middleware('client');


				


Route::group(['namespace' => 'V1','prefix' => 'v1', 'middleware' => 'client'], function () {
				Route::get('{id}', '\App\Http\Controllers\Api\V1\EntriesController@show');
                Route::get('/', '\App\Http\Controllers\Api\V1\EntriesController@all');
});


	// Route::get('/user', function (Request $request) {
	//     return $request->user();
	// })->middleware('auth:api');

	// Route::group(['middleware' => ['auth:api']], function () {
	//     Route::get('/test', function (Request $request) {
	//         return response()->json(['name' => 'test']);
	//     });
	// });
