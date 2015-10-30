<?php

namespace App\Http\Middleware;

use Closure;


class SubdomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $parsed_url=parse_url($request->url());
      $parts=explode('.',$parsed_url['host'],2);
      //$user=User::where(["subdomain" => $parts[0]]);
    }
}
