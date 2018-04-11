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

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '1',
        'redirect_uri' => 'http://127.0.0.1:8000/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);
    return redirect('http://127.0.0.1:8000/oauth/authorize?'.$query);
});

Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://127.0.0.1:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '1',
            'client_secret' => '5ptpjiE1qed0BrpC8FZ3Q403uPGCX4woDYM5IkVb',
            'redirect_uri' => 'http://127.0.0.1:8000/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

	Route::get('/test', function (Request $request) {
	    $guzzle = new GuzzleHttp\Client;

		$response = $guzzle->post('http://127.0.0.1:8000/oauth/token', [
		    'form_params' => [
		        'grant_type' => 'client_credentials',
		        'client_id' => '1',
		        'client_secret' => '5ptpjiE1qed0BrpC8FZ3Q403uPGCX4woDYM5IkVb',
		        'scope' => 'your-scope',
		    ],
		]);
		dd($response->getBody());
		return json_decode((string) $response->getBody(), true);
	})->middleware('client');

	Route::get('/user', function (Request $request) {
	    return $request->user();
	})->middleware('auth:api');

	Route::group(['middleware' => ['auth:api']], function () {
	    Route::get('/test', function (Request $request) {
	        return response()->json(['name' => 'test']);
	    });
	});
