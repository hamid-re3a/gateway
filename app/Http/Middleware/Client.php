<?php

namespace App\Http\Middleware;

use App\Http\Helpers\ResponseData;
use Closure;
use Illuminate\Http\Request;

class Client
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth('api')->user();

        if ($user->hasRole('client'))
            return $next($request);

        return ResponseData::error(trans('responses.unauthorized'));
    }
}
