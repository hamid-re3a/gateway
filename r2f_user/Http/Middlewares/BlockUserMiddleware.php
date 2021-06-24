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
        $user = null;
        if (auth()->check())
            $user = auth()->user();
        else
            $user = User::whereEmail($request->email)->first();
        if($user)
            if(in_array($user->block_type,USER_BLOCK_TYPES))
                return ResponseData::error(trans('responses.user-is-blocked'),[],403);
        return $next($request);
    }
}
