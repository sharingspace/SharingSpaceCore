<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| API Slack Slash Routes
| This doesn't use the API guard, since we cannot pass X-Authenticated headers.
| As such, it shouldn't use the apiguard middleware.
|--------------------------------------------------------------------------
*/
Route::group(
    array('prefix' => 'api/v1/slack'),
    function () {
        Route::post('members', '\App\Http\Controllers\Api\SlackController@slackShowMembers');
        Route::post('entry/{postType}', '\App\Http\Controllers\Api\SlackController@slackAddEntry');
    }
);


Route::group(
    array('prefix' => 'api/v1', 'middleware' => 'apiguard'),
    function () {

        /*
        |--------------------------------------------------------------------------
        | API Member Routes
        |--------------------------------------------------------------------------
        */
        Route::group(
            array('prefix' => 'members'),
            function () {
                Route::get('{id}', '\App\Http\Controllers\Api\UsersController@show');
                Route::get('/', '\App\Http\Controllers\Api\UsersController@all');
            }
        );

        /*
        |--------------------------------------------------------------------------
        | API Entry Routes
        |--------------------------------------------------------------------------
        */
        Route::group(
            array('prefix' => 'entries'),
            function () {
                Route::get('{id}', '\App\Http\Controllers\Api\EntriesController@show');
                Route::get('/', '\App\Http\Controllers\Api\EntriesController@all');
            }
        );


    }
);


Route::group(
    ['prefix' => LaravelLocalization::setLocale()],
    function () {

        /*
        |--------------------------------------------------------------------------
        | Authentication and Authorization Routes
        |--------------------------------------------------------------------------
        */

        Route::group(
            array('prefix' => 'auth'),
            function () {

                // Logout
                Route::get(
                    'logout',
                    array(
                    'as' => 'logout',
                    'uses' => 'Auth\AuthController@getLogout')
                );

                // Login
                Route::get(
                    'login',
                    array(
                    'as' => 'login',
                    'uses' => 'Auth\AuthController@getLogin')
                );

                Route::post('login', 'Auth\AuthController@postLogin');

                // Register
                Route::get(
                    'register',
                    array(
                    'as' => 'register',
                    'uses' => 'Auth\AuthController@getRegister')
                );

                Route::post('register', 'Auth\AuthController@postRegister');

                // Social
                Route::get('{provider}', 'Auth\AuthController@redirectToProvider');
                Route::get('{provider}/callback', 'Auth\AuthController@handleProviderCallback');


            }
        );


        /*
        |--------------------------------------------------------------------------
        | User/Account routes
        |--------------------------------------------------------------------------
        */
        Route::group(
            array('prefix' => 'account', 'middleware' => 'auth'),
            function () {

                Route::get(
                    'history',
                    array(
                    'as' => 'user.history',
                    'uses' => 'UserController@getHistory')
                );

                Route::get(
                    'memberships',
                    array(
                    'as' => 'account.memberships.view',
                    'uses' => 'UserController@getCommunityMemberships')
                );

                Route::get(
                    'leave/{communityId?}',
                    array(
                    'middleware' => 'community-auth',
                    'as' => 'leave-community',
                    'uses' => 'UserController@getLeaveCommunity')
                );

                Route::get(
                    'settings',
                    array(
                    'as' => 'user.settings.view',
                    'uses' => 'UserController@getSettings')
                );

                Route::post(
                    'settings',
                    array(
                    'as' => 'user.settings.save',
                    'uses' => 'UserController@postSettings')
                );

                Route::get(
                    'messages',
                    array(
                    'as' => 'messages.view',
                    'uses' => 'MessagesController@getIndex')
                );

                Route::get(
                    'message/{messageId}',
                    array(
                    'as' => 'message.view',
                    'uses' => 'MessagesController@getMessage')
                );

                Route::get(
                    'messages/ajax',
                    array(
                    'as' => 'messages.view.ajax',
                    'uses' => 'MessagesController@getMessagesDataView')
                );


                Route::post(
                    'password',
                    array(
                    'as' => 'user.password.save',
                    'uses' => 'UserController@postUpdatePassword')
                );

                Route::post(
                    'privacy',
                    array(
                    'as' => 'user.privacy.save',
                    'uses' => 'UserController@postUpdatePrivacy')
                );

                Route::post(
                    'social',
                    array(
                    'as' => 'user.social.save',
                    'uses' => 'UserController@postUpdateSocial')
                );

                Route::post(
                    'avatar',
                    array(
                    'as' => 'user.avatar.save',
                    'uses' => 'UserController@postUpdateAvatar')
                );

                Route::post(
                    'notification',
                    array(
                    'as' => 'user.notifications.save',
                    'uses' => 'UserController@postUpdateNotifications')
                );
        });


        Route::group(
            array('prefix' => 'users'),
            function () {

                Route::get(
                    '{userID}',
                    array(
                    'middleware' => ['auth','community-auth', 'member-auth'],
                    'as' => 'user.profile',
                    'uses' => 'UserController@getProfile')
                );

                Route::post(
                    '{entryId}/ajaxdelete',
                    array(
                    'middleware' => 'auth',
                    'uses' => 'EntriesController@postAjaxDelete')
                );
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Entry routes
        |--------------------------------------------------------------------------
        */
        Route::group(
            array('prefix' => 'entry'),
            function () {

                Route::get(
                    'new',
                    array(
                    'middleware' => ['auth','community-auth','entry-auth'],
                    'as' => 'entry.create.form',
                    'uses' => 'EntriesController@getCreate')
                );

                Route::post(
                    'new',
                    array(
                    'middleware' => ['auth','community-auth'],
                    'as' => 'entry.create.save',
                    'uses' => 'EntriesController@postCreate')
                );

                Route::post(
                    'new/ajax',
                    array(
                    'middleware' => ['auth','community-auth'],
                    'as' => 'entry.create.ajax.save',
                    'uses' => 'EntriesController@postAjaxCreate')
                );

                Route::post(
                    '{entryID}/delete',
                    array(
                    'middleware' => ['auth','community-auth'],
                    'as' => 'entry.delete.save',
                    'uses' => 'EntriesController@postDelete')
                );

                Route::post(
                    '{entryID}/delete/ajax',
                    array(
                    'middleware' => ['auth','community-auth'],
                    'as' => 'entry.delete.ajax.save',
                    'uses' => 'EntriesController@postAjaxDelete')
                );

                Route::post(
                    'messages/new/{userId}/{entryId?}',
                    array(
                    'as' => 'messages.create.save',
                    'uses' => 'MessagesController@postCreate')
                );

                Route::get(
                    '{entryID}/edit',
                    array(
                    'middleware' => ['auth','community-auth'],
                    'as' => 'entry.edit.form',
                    'uses' => 'EntriesController@getEdit')
                );

                Route::post(
                    '{entryID}/edit/ajax',
                    array(
                    'middleware' => ['auth','community-auth'],
                    'as' => 'entry.edit.ajax.save',
                    'uses' => 'EntriesController@postAjaxEdit')
                );

                Route::post(
                    '{entryID}/edit',
                    array(
                    'middleware' => ['auth','community-auth'],
                    'as' => 'entry.edit.save',
                    'uses' => 'EntriesController@postEdit')
                );

                Route::get(
                    '{entryID}/ajaxgetentry',
                    array(
                    'middleware' => ['auth','community-auth'],
                    'as' => 'entry.ajax.get',
                    'uses' => 'EntriesController@ajaxGetEntry')
                );

                Route::post(
                    'upload',
                    array(
                    'middleware' => ['auth','community-auth'],
                    'uses' => 'EntriesController@ajaxUpload')
                );

                Route::get(
                    'json.browse/{userId?}',
                    array(
                    'middleware' => ['community-auth'],
                    'as' => 'json.browse',
                    'uses' => 'EntriesController@getEntriesDataView')
                );

                Route::get(
                    '{entryID}',
                    array(
                    'middleware' => ['auth','community-auth'],
                    'as' => 'entry.view',
                    'uses' => 'EntriesController@getEntry')
                );

                Route::get(
                    '{entryID}/completed',
                    array(
                    'middleware' => ['auth','community-auth'],
                    'as' => 'entry.completed',
                    'uses' => 'EntriesController@completeEntry')
                );
            }
        );




        /*
        |--------------------------------------------------------------------------
        | Community routes
        |--------------------------------------------------------------------------
        */

        Route::get(
            'browse',
            array(
            'as' => 'browse',
            'middleware' => 'community-auth',
            'uses' => 'CommunitiesController@getEntriesView')
        );

        Route::get(
            'kiosk',
            array(
            'as' => 'kiosk',
            'middleware' => 'community-auth',
            'uses' => 'CommunitiesController@getKioskEntriesView')
        );

        Route::post(
            '{entryId}/ajaxdelete',
            array(
            'middleware' => ['auth','community-auth'],
            'uses' => 'EntriesController@postAjaxDelete')
        );

        Route::get(
            'members',
            array(
            'middleware' => 'community-auth',
            'as' => 'members',
            'uses' => 'CommunitiesController@getMembers')
        );
       Route::get(
            'accept',
            array(
            'middleware' => 'auth',
            'as' => 'accept-user',
            'uses' => 'UserController@getAcceptUser')
        );
        Route::get(
            'reject',
            array(
            'middleware' => 'auth',
            'as' => 'reject-community',
            'uses' => 'UserController@getRejectUser')
        );
        Route::get(
            'join',
            array(
            'middleware' => 'auth',
            'as' => 'join-community',
            'uses' => 'UserController@getJoinCommunity')
        );

        Route::get(
            'requests',
            array(
            'middleware' => 'auth',
            'as' => 'join-requests',
            'uses' => 'CommunitiesController@getJoinRequests')
        );
        
        Route::group(
            array('prefix' => 'community'),
            function () {

                Route::get(
                    'new',
                    array(
                    'middleware' => 'auth',
                    'as' => 'community.create.form',
                    'uses' => 'CommunitiesController@getCreate')
                );

                Route::post(
                    'new',
                    array(
                    'middleware' => 'auth',
                    'as' => 'community.create.save',
                    'uses' => 'CommunitiesController@postCreate')
                );

                Route::get(
                    'edit',
                    array(
                    'middleware' => ['auth','community-auth'],
                    'as' => 'community.edit.form',
                    'uses' => 'CommunitiesController@getEdit')
                );

                Route::post(
                    'edit',
                    [
                    'middleware' => ['auth','community-auth'],
                    'as' => 'community.edit.save',
                    'uses' => 'CommunitiesController@postEdit'
                    ]
                );

            }
        );



        // Request access to a community
        Route::get(
            'request-access',
            [
            'middleware' => ['auth'],
            'as' => 'community.request-access.form',
            'uses' => 'CommunitiesController@getRequestAccess'
            ]
        );

        // Request access to a community
        Route::post(
            'request-access',
            [
            'middleware' => ['auth'],
            'as' => 'community.request-access.save',
            'uses' => 'CommunitiesController@postRequestAccess'
            ]
        );

        Route::get(
            'join-open',
            array(
            'middleware' => 'auth',
            'uses' => 'UserController@getJoinCommunity')
        );

        // Stripe Webhook...
        Route::post(
            'webhook/stripe',
            [
            'as' => 'stripe.webhook',
            'uses' => 'StripeWebhookController@handleWebhook' ]
        );

        /*
        |--------------------------------------------------------------------------
        | Admin routes
        |--------------------------------------------------------------------------
        */
        Route::group(
            array('prefix' => 'admin', 'middleware' => 'auth'),
            function () {

                Route::get(
                    '/',
                    array(
                        'as' => 'admin.index',
                        'uses' => 'AdminController@getCustomerList')
                );
        });

        /*
        |--------------------------------------------------------------------------
        | Default homepage stuff
        |--------------------------------------------------------------------------
        */
        Route::get(
            'features', 
            array('as' => 'features',
                function () {
                    return view('features');
                }
            )
        );

        Route::get(
            'terms',
            function () {
                return view('tos');
            }
        );

        Route::get(
            'privacy',
            function () {
                return view('privacy');
            }
        );

        Route::get(
            'home',
            function () {
                return redirect('/');
            }
        );

        Route::get(
            'about',
            array('as' => 'about',
                function () {
                    return view('about');
                }
            )
        );

        Route::get(
            'coop',
             array(
                'as' => 'coop',
                'uses' => 'PagesController@getCoopPage')
        );

        Route::post(
            'coop',
            array(
                'middleware' => ['auth'],
                'as' => 'coop.submit',
                'uses' => 'PagesController@postChargeCoop')
        );

        Route::get(
            'coop/coop_success', 
            array(
                'as' => 'coop_success',
                function () {
                    return view('coop_success');
            })
        );

        Route::get(
            'pricing',
            function () {
                return view('pricing');
            }
        );

        Route::get(
            'financial_assist',
            array(
            'as' => 'assistance',
            function () {
                return view('assistance');
            })
        );

        Route::post(
            'financial_assist',
            array(
            'as' => 'assistance',
            'uses' => 'PagesController@postFinancialAssist'
            )
        );

        Route::get(
            '/',
            array(
            'as' => 'home',
            'middleware' => ['community-auth'],
            'uses' => 'PagesController@getHomepage')
        );
    }
);
