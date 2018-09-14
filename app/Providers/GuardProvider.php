<?php
namespace App\Providers;

use Dingo\Api\Auth\Provider\Authorization;
use Dingo\Api\Routing\Route;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class GuardProvider extends Authorization
{
    /**
     * Get the providers authorization method.
     *
     * @return string
     */
    public function getAuthorizationMethod()
    {
        return 'X-Authorization';
    }

    /**
     * Authenticate the request and return the authenticated user instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Dingo\Api\Routing\Route $route
     *
     * @return mixed
     */
    public function authenticate(Request $request, Route $route)
    {
        $key = $request->header(env('API_AUTH_HEADER', 'X-Authorization'));
        if (empty($key)) $key = $request->input(env('API_AUTH_HEADER', 'X-Authorization'));
        if (empty($key)) throw new UnauthorizedHttpException('Guard', 'The supplied API KEY is missing or an invalid authorization header was sent');

        $user = app('db')->select("SELECT * FROM users WHERE users.key = ?", [$key]);
        if (!$user) throw new UnauthorizedHttpException('Guard', 'The supplied API KEY is not valid');

        return $user;
    }
}

?>