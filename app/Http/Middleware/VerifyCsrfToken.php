<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
      'webhook/stripe',
      'api/*',
      'api/v1/slack/members',
      'api/v1/slack/entry/*',
      'api/v1/entries/create',
      'api/test',
      'oauth/token',
      'github-webhook'
    ];
}
