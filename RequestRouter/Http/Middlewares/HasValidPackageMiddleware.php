<?php

namespace RequestRouter\Http\Middlewares;


use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use MLM\Services\Grpc\Acknowledge;
use User\Models\User;
use RequestRouter\Services\GatewayService;

class HasValidPackageMiddleware
{

    public function handle($request, Closure $next)
    {
        try {
            if (auth()->check() AND auth()->user()->roles()->count() == 1 AND auth()->user()->hasRole(USER_ROLE_CLIENT)) {
                $cacheKey = 'user_has_valid_package_' . auth()->user()->id;

                if (!cache()->has($cacheKey)) {

                    /** @var $acknowledge Acknowledge */
                    list($acknowledge,$stats) = getMLMGrpcClient()->hasValidPackage(auth()->user()->getUserService())->wait();

                    if ($stats->code == 0) {

                        if ($acknowledge->getStatus()) {

                            //User has valid package
//                            cache()->put($cacheKey, true);

                        } else {

                            //User hasn't valid package
                            return api()->error(null, [
                                'has_valid_package' => false,
                            ], 499);

                        }
                    }

                }
            }
        } catch (\Throwable $exception) {
            Log::error('HasValidPackage middleware exception . Exception =>  ' . $exception->getMessage() );
            return api()->error(null, [
                'has_valid_package' => false,
            ],499);
        }
        return $next($request);
    }

}
