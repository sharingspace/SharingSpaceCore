<?php
/**
 * This Middleware checks to see if the url is currently a sub-domain,
 * and then gets the whitelabel community information if it's a
 * valid subdomain.
 *
 * If the subdomain is valid, we add that community info to an object
 * called $request->valid_whitelabel, which is available in the blades and
 * and available to any controller method as long as the Request $request
 * is passed as a controller method parameter.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Http\Middleware;

use Closure;
use Config;
use App\Community;
use Carbon\Carbon;

function extract_domain($domain)
{
    if (preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches)) {
        return $matches['domain'];
    } else {
        return $domain;
    }
}

function extract_subdomains($domain)
{
    $subdomains = $domain;
    $domain = extract_domain($subdomains);

    $subdomains = rtrim(strstr($subdomains, $domain, true), '.');

    return $subdomains;
}


class SubdomainMiddleware
{
    /**
   * Check if the whitelabel group is valid
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure                 $next
   * @return mixed
   */
    public function handle($request, Closure $next)
    {

        $parsed_url = parse_url($request->url());
        $subdomain = extract_subdomains($parsed_url['host']);
        $now = Carbon::now();

        // FIXME - add   ->where('subdomain_expires_at', '>', $now) back in
        if (($subdomain!='') && ($subdomain!='www') && ($subdomain!='api')) {
            $group = Community::where('subdomain', '=', $subdomain)
            ->whereNotNull('subdomain')->first();

            if ($group) {

                $request->valid_whitelabel = true;
                $request->whitelabel_group = $group;
                $request->corporate_default = false;
                view()->share('whitelabel_group', $request->whitelabel_group);
                view()->share('valid_whitelabel', $request->valid_whitelabel);

            } else {
                $request->valid_whitelabel = false;
                $request->corporate_default = false;
                return redirect(Config::get('app.url'));
            }

        } else {
            $request->valid_whitelabel = false;
            $request->corporate_default = true;

        }

        return $next($request);

    }
}
