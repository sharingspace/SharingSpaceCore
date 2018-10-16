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
//Route::group(
//    ['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localize']],
//    function () {

        /*
        |--------------------------------------------------------------------------
        | Authentication and Authorization Routes
        |--------------------------------------------------------------------------
        */


        Auth::routes();

        Route::get('logout', function () {
            Auth::logout();
            return redirect('/');
        });

        Route::group(
            array('prefix' => 'login'),
            function () {
                // Social
                Route::get('{provider}', 'Auth\LoginController@redirectToSocialProvider');
                Route::get('{provider}/callback', 'Auth\LoginController@handleProviderCallback');
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
                    'orders',
                    array(
                        'uses' => 'UserController@getHistory',
                    )
                )->name('_orders');

                Route::get(
                    'memberships',
                    array(
                        'uses' => 'UserController@getCommunityMemberships',
                    )
                )->name('_memberships');

                Route::get(
                    'leave/{communityId}',
                    array(
                        'middleware' => 'community-auth',
                        'as'         => 'leave-community',
                        'uses'       => 'UserController@getLeaveCommunity',
                    )
                );

                Route::get(
                    'settings',
                    array(
                        'as'   => 'user.settings.view',
                        'uses' => 'UserController@getSettings',
                    )
                );

                Route::post(
                    'settings',
                    array(
                        'as'   => 'user.settings.save',
                        'uses' => 'UserController@postSettings',
                    )
                );

                Route::get(
                    'messages',
                    array(
                        'as'   => 'messages.view',
                        'uses' => 'MessagesController@getIndex',
                    )
                );

                Route::get(
                    'message/thread/{messageId}',
                    array(
                        'as'   => 'messages.view',
                        'uses' => 'MessagesController@getMessageThread',
                    )
                );

                Route::get(
                    'message/{messageId}',
                    array(
                        'as'   => 'message.view',
                        'uses' => 'MessagesController@getMessage',
                    )
                );

                Route::post(
                    'message/thread/ajaxdelete/{messageId}',
                    array(
                        'as'   => 'message.delete',
                        'uses' => 'MessagesController@postDeleteMessage',
                    )
                );

                Route::get(
                    'messages/ajax',
                    array(
                        'as'   => 'messages.view.ajax',
                        'uses' => 'MessagesController@getMessagesDataView',
                    )
                );


                Route::post(
                    'password',
                    array(
                        'as'   => 'user.password.save',
                        'uses' => 'UserController@postUpdatePassword',
                    )
                );

                Route::post(
                    'privacy',
                    array(
                        'as'   => 'user.privacy.save',
                        'uses' => 'UserController@postUpdatePrivacy',
                    )
                );

                Route::post(
                    'social',
                    array(
                        'as'   => 'user.social.save',
                        'uses' => 'UserController@postUpdateSocial',
                    )
                );

                Route::post(
                    'avatar',
                    array(
                        'as'   => 'user.avatar.save',
                        'uses' => 'UserController@postUpdateAvatar',
                    )
                );

                Route::post(
                    'notification',
                    array(
                        'as'   => 'user.notifications.save',
                        'uses' => 'UserController@postUpdateNotifications',
                    )
                );
            }
        );


        Route::group(
            array('prefix' => 'users'),
            function () {

                Route::get(
                    '{userID}',
                    array(
                        'middleware' => ['member-auth'],
                        'as'         => 'user.profile',
                        'uses'       => 'UserController@getProfile',
                    )
                );

                Route::post(
                    '{entryId}/ajaxdelete',
                    array(
                        'middleware' => 'auth',
                        'uses'       => 'EntriesController@postAjaxDelete',
                    )
                );

                Route::post(
                    '{userId}',
                    array(
                        'middleware' => ['auth', 'community-auth'],
                        'uses'       => 'MessagesController@postCreate',
                    )
                )->name('_send_profile_message');
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
                        'middleware' => ['auth', 'community-auth', 'entry-auth'],
                        'as'         => 'entry.create.form',
                        'uses'       => 'EntriesController@getCreate',
                    )
                );

                Route::post(
                    'new',
                    array(
                        'middleware' => ['auth', 'community-auth'],
                        'as'         => 'entry.create.save',
                        'uses'       => 'EntriesController@postCreate',
                    )
                );

                Route::post(
                    'new/ajax',
                    array(
                        'middleware' => ['auth', 'community-auth'],
                        'as'         => 'entry.create.ajax.save',
                        'uses'       => 'EntriesController@postAjaxCreate',
                    )
                );

                Route::post(
                    '{entryID}/delete',
                    array(
                        'middleware' => ['auth', 'community-auth'],
                        'as'         => 'entry.delete.save',
                        'uses'       => 'EntriesController@postDelete',
                    )
                );

                Route::post(
                    '{entryID}/delete/ajax',
                    array(
                        'middleware' => ['auth', 'community-auth'],
                        'as'         => 'entry.delete.ajax.save',
                        'uses'       => 'EntriesController@postAjaxDelete',
                    )
                );

                Route::post(
                    'messages/new/{userId}/{entryId?}',
                    array(
                        'middleware' => ['auth', 'community-auth'],
                        'as'         => 'messages.create.save',
                        'uses'       => 'MessagesController@postCreate',
                    )
                );

                Route::post(
                    '{entryID}/edit/ajax',
                    array(
                        'middleware' => ['auth', 'community-auth'],
                        'as'         => 'entry.edit.ajax.save',
                        'uses'       => 'EntriesController@postAjaxEdit',
                    )
                );

                Route::get(
                    '{entryID}/edit',
                    array(
                        'middleware' => ['auth', 'community-auth', 'entry-edit'],
                        'as'         => 'entry.edit.form',
                        'uses'       => 'EntriesController@getEdit',
                    )
                );

                Route::post(
                    '{entryID}/edit',
                    array(
                        'middleware' => ['auth', 'community-auth'],
                        'as'         => 'entry.edit.save',
                        'uses'       => 'EntriesController@postEdit',
                    )
                );

                Route::get(
                    '{entryID}/ajaxgetentry',
                    array(
                        'middleware' => ['auth', 'community-auth'],
                        'as'         => 'entry.ajax.get',
                        'uses'       => 'EntriesController@ajaxGetEntry',
                    )
                );

                Route::post(
                    'uploadimage',
                    array(
                        'middleware' => ['auth', 'community-auth'],
                        'uses'       => 'EntriesController@ajaxUpload',
                    )
                );

                Route::get(
                    'json.browse/{userId?}',
                    array(
                        'middleware' => ['entry-browse'],
                        'as'         => 'json.browse',
                        'uses'       => 'EntriesController@getEntriesDataView',
                    )
                );

                Route::get(
                    'kiosk/{tagName?}',
                    array(
                        'middleware' => ['community-auth'],
                        'uses'       => 'EntriesController@getKioskEntries',
                    )
                )->name('_kiosk_categories');

                Route::get(
                    'kiosk/kiosk_entry/{entryId}',
                    array(
                        'middleware' => ['entry-view'],
                        'uses'       => 'EntriesController@getEntry',
                    )
                )->name('_kiosk_entry');

                Route::get(
                    '{entryId}',
                    array(
                        'middleware' => ['entry-view'],
                        'as'         => 'entry.view',
                        'uses'       => 'EntriesController@getEntry',
                    )
                );

                Route::get(
                    '{entryID}/completed',
                    array(
                        'middleware' => ['auth', 'community-auth'],
                        'as'         => 'entry.completed',
                        'uses'       => 'EntriesController@completeEntry',
                    )
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
                'as'         => 'browse',
                'middleware' => ['home-view'],
                'uses'       => 'CommunitiesController@getEntriesView',
            )
        );

        Route::post(
            '{entryId}/ajaxdelete',
            array(
                'middleware' => ['auth', 'community-auth'],
                'uses'       => 'EntriesController@postAjaxDelete',
            )
        );

        Route::get(
            'members',
            array(
                'middleware' => 'community-auth',
                'as'         => 'members',
                'uses'       => 'CommunitiesController@getMembers',
            )
        );
        Route::get(
            'accept',
            array(
                'middleware' => 'auth',
                'as'         => 'accept-user',
                'uses'       => 'UserController@getAcceptUser',
            )
        );
        Route::get(
            'reject',
            array(
                'middleware' => 'auth',
                'as'         => 'reject-community',
                'uses'       => 'UserController@getRejectUser',
            )
        );
        Route::get(
            'join',
            array(
                'middleware' => 'auth',
                'as'         => 'join-community',
                'uses'       => 'UserController@getJoinCommunity',
            )
        );

        Route::get(
            'requests',
            array(
                'middleware' => 'auth',
                'as'         => 'join-requests',
                'uses'       => 'CommunitiesController@getJoinRequests',
            )
        );

        Route::group(
            array('prefix' => 'share'),
            function () {

                Route::get(
                    'new',
                    array(
                        'middleware' => 'auth',
                        'as'         => 'community.create.form',
                        'uses'       => 'CommunitiesController@getCreate',
                    )
                );

                Route::post(
                    'new',
                    array(
                        'middleware' => 'auth',
                        'as'         => 'community.create.save',
                        'uses'       => 'CommunitiesController@postCreate',
                    )
                );

                Route::get(
                    'edit',
                    [
                        'middleware' => ['auth', 'community-edit'],
                        'uses'       => 'CommunitiesController@getEdit',
                    ]
                )->name('_edit_share');

                Route::post(
                    'edit',
                    [
                        'middleware' => ['auth', 'community-edit'],
                        'uses'       => 'CommunitiesController@postEdit',
                    ]
                );

                Route::get(
                    'update-pois',
                    [
                        'middleware' => ['auth', 'community-edit'],
                        'uses'       => 'CommunitiesController@updatePois',
                    ]
                )->name('_update_share_pois');

            }
        );


        // Request access to a community , 'community-auth'
        Route::get(
            'request-access',
            [
                'middleware' => ['auth'],
                'as'         => 'community.request-access.form',
                'uses'       => 'CommunitiesController@getRequestAccess',
            ]
        );

        // Request access to a community
        Route::post(
            'request-access',
            [
                'middleware' => ['auth'],
                'as'         => 'community.request-access.save',
                'uses'       => 'CommunitiesController@postRequestAccess',
            ]
        );

        Route::get(
            'join-open',
            array(
                'middleware' => 'auth',
                'as'         => 'join-open-community',
                'uses'       => 'UserController@getJoinCommunity',
            )
        );

        // Stripe Webhook...
        Route::post(
            'webhook/stripe',
            [
                'as'   => 'stripe.webhook',
                'uses' => 'StripeWebhookController@handleWebhook',
            ]
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
                        'as'   => 'admin.index',
                        'uses' => 'AdminController@getCustomerList',
                    )
                );
                Route::get(
                    'create_thumbnails',
                    array(
                        'middleware' => ['auth', 'community-auth'],
                        'uses'       => 'AdminController@createThumbnails',
                    )
                );
            });

        /*
        |--------------------------------------------------------------------------
        | Default homepage stuff
        |--------------------------------------------------------------------------
        */
        Route::get(
            'product',
            array(
                'as' => 'product',
                function () {
                    return view('product');
                },
            )
        );

        Route::get(
            'terms',
            function () {
                return view('tos');
            }
        )->name('tos');

        Route::get(
            'privacy',
            array(
                'as' => 'privacy',
                function () {
                    return view('privacy');
                },
            )
        );

        Route::get(
            'sharing_networks',
            function () {
                return view('sharing_networks');
            }
        )->name('_sharing_networks');

        Route::get(
            'how_it_works',
            function () {
                return view('how_it_works');
            }
        )->name('_how_it_works');

        Route::get(
            'sharing_spaces',
            function () {
                return view('sharing_spaces');
            }
        )->name('_sharing_spaces');

        Route::get(
            'sharing_examples',
            function () {
                return view('sharing_examples');
            }
        )->name('_sharing_examples');

        Route::get(
            'sharing_spaces_waitlist',
            function () {
                return view('sharing_spaces_waitlist');
            }
        )->name('_sharing_spaces_waitlist');

        Route::get(
            'sharing_examples',
            function () {
                return view('sharing_examples');
            }
        )->name('_sharing_examples');

        Route::get(
            'home',
            function () {
                return redirect('/');
            }
        );

        Route::get(
            'about',
            array(
                'as' => 'about',
                function () {
                    return view('about');
                },
            )
        );

        Route::get(
            'coop',
            array(
                'as'   => 'coop',
                'uses' => 'PagesController@getCoopPage',
            )
        );

        Route::post(
            'coop',
            array(
                'middleware' => ['auth'],
                'as'         => 'coop.submit',
                'uses'       => 'PagesController@postChargeCoop',
            )
        );

        Route::get(
            'coop/coop_success',
            array(
                'as' => 'coop_success',
                function () {
                    return view('coop_success');
                },
            )
        );

        Route::get(
            'pricing',
            array(
                'as' => 'memberships',
                function () {
                    return view('pricing');
                },
            )
        );

        Route::get(
            'financial_assist',
            array(
                'as' => 'assistance',
                function () {
                    return view('assistance');
                },
            )
        );

        Route::post(
            'financial_assist',
            array(
                'as'   => 'assistance',
                'uses' => 'PagesController@postFinancialAssist',
            )
        );

        Route::get(
            '/',
            array(
                'as'   => 'home',
                'uses' => 'PagesController@getHomepage',
            )
        );

        Route::get(
            'fs/{layout}',
            function($layout) {
                return view('full_screen', ['entry_layout' => $layout]);
            }
        );

        Route::get(
            'debug_off',
            function () {
                config(['app.debug' => false]);
                return redirect('/');
            }
        );

        Route::get(
            'debug_on',
            function () {
                config(['app.debug' => true]);
                return redirect('/');
            }
        );
    }
);

