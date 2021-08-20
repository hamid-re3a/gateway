<?php

namespace RequestRouter\Http\Middlewares;


use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Route;
use User\Services\GatewayService;

class HasValidPackageMiddleware
{

    public function handle($request, Closure $next)
    {
        if (auth()->check()) {

            $cacheKey = 'user_has_valid_package_' . auth()->user()->id;

            if(!cache()->has($cacheKey)){

                $client = new \GuzzleHttp\Client(['headers' => $this->performHeaders()]);
                $res = $client->request('GET', $this->getUrl());

                if ($res->getStatusCode() == 200) {

                    $response = json_decode($res->getBody()->getContents());
                    if($response->data->has_valid_package) {

                        //User has valid package
                        cache()->put($cacheKey,$response->data->has_valid_package);

                    } else {

                        //User hasn't valid package
                        return api()->error(null, [
                            'has_valid_package' => false,
                        ], 499);

                    }
                }

            }
        }
        return $next($request);
    }

    private function getUrl()
    {
        $gatewayService = app(GatewayService::class)->getAllGatewayServices();
        $gatewayService = $gatewayService->where('name','subscription')->first();
        if($gatewayService)
            $externalDomain = $gatewayService->domain;
        else
            $externalDomain = config('gateway.services.subscription.domain');

        return $externalDomain . 'v1/orders/packages/has-valid-package';
    }

    private function performHeaders()
    {
        return [
            'X-user-id' => auth()->user()->id
        ];
    }
}