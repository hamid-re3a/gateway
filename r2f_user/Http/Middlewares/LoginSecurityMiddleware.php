<?php

namespace R2FUser\Http\Middlewares;

use App\Http\Helpers\ResponseData;
use R2FUser\Support\Google2FAAuthenticator;
use Closure;

class LoginSecurityMiddleware
{

    public function handle($request, Closure $next)
    {
        $authenticator = app(Google2FAAuthenticator::class)->bootStateless($request);
        if ($authenticator->isAuthenticated()) {
            return $next($request);
        }

        return ResponseData::error(trans('responses.unauthorized'),[],401);
    }
}
