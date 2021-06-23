<?php

namespace R2FGateway\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class GatewayController extends Controller
{

    /**
     * @hideFromAPIDocumentation
     */
    public function aggregate(Request $request)
    {
        $method = strtolower($request->method());
        $route = str_replace('api/gateway/', '', $request->path());
        $headers = $request->headers->keys();
        $user_agent = $request->userAgent();
        $contents = $request->getContent();
        foreach(config('gateway.routes') as $key =>$route)
            echo $route['services'];


        if (\Str::startsWith($route, 'default/')) {
            $route = str_replace('default/', '', $route);
            $request = Request::create('http://localhost:3541/api/' . $route, $method);
            return Route::dispatch($request);
        }




        return Http::withHeaders($headers)
            ->withBody($contents,$request->getContentType())
            ->withUserAgent($user_agent)->
            $method('https://jsonplaceholder.typicode.com/posts');

    }
}
