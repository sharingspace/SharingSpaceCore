<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \App\Http\Middleware\SubdomainMiddleware::class,

        // Anything that requires we have knowledge of the current community
        // goes here, since we get that info above in SubdomainMiddleware
        \App\Http\Middleware\ThemeMiddleware::class,
		\Barryvdh\Cors\HandleCors::class,
    ];


    protected $middlewareGroups = [
        'web' => [ // THIS IS THE GROUP WE ARE TALKING ABOUT
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
        ],
        'api' => [
            'throttle:60,1',
            'bindings',
            'cors',
			\Barryvdh\Cors\HandleCors::class,
        ],
    ];
    
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'subdomain' => \App\Http\Middleware\SubdomainMiddleware::class,
        'community-auth'=> \App\Http\Middleware\CommunityPermissionMiddleware::class,
        'community-edit'=> \App\Http\Middleware\CommunityEditMiddleware::class, 
        'member-auth'=> \App\Http\Middleware\MemberPermissionMiddleware::class,
        'entry-auth'=> \App\Http\Middleware\EntryPermissionMiddleware::class,
        'apiguard' => \Chrisbjr\ApiGuard\Http\Middleware\ApiGuard::class,
        'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'entry-view' => \App\Http\Middleware\EntryView::class,
        'entry-edit' => \App\Http\Middleware\EntryEdit::class,
        'entry-browse' => \App\Http\Middleware\EntryBrowse::class,
        'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'client' => CheckClientCredentials::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'cors' => \App\Http\Middleware\Cors::class,
    ];
}
