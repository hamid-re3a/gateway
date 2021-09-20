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

                    $client = new \GuzzleHttp\Client([
                        'headers' => $this->performHeaders()
                    ]);


                    /** @var $acknowledge Acknowledge */
                    list($stats,$acknowledge) = getMLMGrpcClient()->hasValidPackage(auth()->user()->getUserService());

                    if ($stats == 0) {

                        if ($acknowledge->getStatus()) {

                            //User has valid package
                            cache()->put($cacheKey, true);

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

    private function getUrl()
    {
        $gatewayService = app(GatewayService::class)->getAllGatewayServices();
        $gatewayService = $gatewayService->where('name', 'subscription')->first();
        if ($gatewayService)
            $externalDomain = $gatewayService->domain;
        else
            $externalDomain = config('gateway.services.subscription.domain');

        return $externalDomain . 'v1/orders/packages/has-valid-package';
    }

    private function performHeaders()
    {

        $user = request()->user();
        $user_service = $user->getUserService();

        return [
            'X-user-id' => $user->id,
            'X-user-hash' => md5(serialize($user_service))
        ];

    }
}
