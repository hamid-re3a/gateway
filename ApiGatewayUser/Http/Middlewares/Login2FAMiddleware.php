<?php

namespace ApiGatewayUser\Http\Middlewares;


use ApiGatewayUser\Support\Google2FAAuthenticator;
use Closure;

class Login2FAMiddleware
{

    public function handle($request, Closure $next)
    {
        $authenticator = app(Google2FAAuthenticator::class)->bootStateless($request);
        if ($authenticator->isAuthenticated()) {
            return $next($request);
        }
        return api()->error(trans('responses.unauthorized'),[],401);
    }
}
