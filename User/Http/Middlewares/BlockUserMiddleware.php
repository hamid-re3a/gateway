<?php

namespace User\Http\Middlewares;


use User\Models\User;
use User\Support\Google2FAAuthenticator;
use Closure;

class BlockUserMiddleware
{

    public function handle($request, Closure $next)
    {
        $user = null;
        if (auth()->check())
            $user = auth()->user();
        else
            $user = User::whereEmail($request->email)->first();
        if($user)
            if(in_array($user->block_type,USER_BLOCK_TYPES))
                return api()->error(trans('responses.user-is-blocked'),[],403);
        return $next($request);
    }
}
