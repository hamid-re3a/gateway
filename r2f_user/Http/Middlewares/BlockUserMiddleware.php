<?php

namespace R2FUser\Http\Middlewares;

use App\Http\Helpers\ResponseData;
use R2FUser\Models\User;
use R2FUser\Support\Google2FAAuthenticator;
use Closure;

class BlockUserMiddleware
{

    public function handle($request, Closure $next)
    {
        if (auth()->check() && !in_array(auth()->user()->block_type,[USER_BLOCK_TYPE_AUTOMATIC])) {
            return $next($request);
        }
        $user = User::whereEmail($request->email)->first();
        if($user  && !in_array($user->block_type,[USER_BLOCK_TYPE_AUTOMATIC]))
            return $next($request);
        return ResponseData::error(trans('responses.user-is-blocked'),[],401);
    }
}
