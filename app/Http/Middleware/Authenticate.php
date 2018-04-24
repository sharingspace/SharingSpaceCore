<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use Log;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        
        if ($this->auth->guest()) {
            
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }
            else if($request->whitelabel_group && $request->whitelabel_group->group_type != 'S') {
                return $next($request);
            }
            else {
                return redirect()->guest('login')->with('info', trans('auth.must_login'));
            }
        }

        return $next($request);
    }
}
