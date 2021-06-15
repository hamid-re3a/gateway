<?php

namespace R2FUser\Http\Middlewares;

use App\Http\Helpers\ResponseData;
use R2FUser\Support\Google2FAAuthenticator;
use Closure;

class EmailVerifiedMiddleware
{

    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isEmailVerified()) {
            return $next($request);
        }
        return ResponseData::error(trans('responses.unauthorized-email-is-not-verified'),[],401);
    }
}
