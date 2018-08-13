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
use App\Models\Community;
use Carbon\Carbon;
use Log;
use Route;
use Redirect;

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
        //LOG::debug('SubdomainMiddleware: entered: path = '.$request->path());
        
        $parsed_url = parse_url($request->url());
        $subdomain = extract_subdomains($parsed_url['host']);
        $now = Carbon::now();

        if (0) {

            if ((strpos($request->path(), 'register') !== FALSE) && $subdomain) {
                // if someone is registering from a  whitelabel, redirect them to register
                // on the corporate site. 
                $url = str_replace($subdomain.".", '', $request->url());

                return redirect($url)->with('subdomain', $subdomain);
            }
            else if ((strpos($request->path(), 'join') !== FALSE) && $request->subdomain) {

                $parsed_url = parse_url($request->url());
                $url = $parsed_url['scheme'].'://'.$request->subdomain.'.'.$parsed_url['host'].'/join';
                //LOG::debug('SubdomainMiddleware: scheme ='.$parsed_url['scheme'].'  '.$request->subdomain.'.'.$parsed_url['host'].'   '.$url);

                return redirect($url);
            }
        }

        // FIXME - add   ->where('subdomain_expires_at', '>', $now) back in

        if (($subdomain!='') && ($subdomain!=env('SITE_ON')) && ($subdomain!='api')) {

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
                return redirect(config('app.url'));
            }

        } else {
            $request->valid_whitelabel = false;
            $request->corporate_default = true;

        }

        return $next($request);
    }
}
