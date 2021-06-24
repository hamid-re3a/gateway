<?php

namespace R2FGateway\Http\Controllers;

use App\Http\Helpers\ResponseData;
use App\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $content_type = $request->getContentType() ?? "application/json";
        $routes = config('gateway.routes');
        $services = config('gateway.services');
        $service_keys = collect(config('gateway.services'))->keys()->toArray();

        if (preg_match('/^(?P<service>.*?)(?=\/)\/(?P<route>.*)|(?P<second_service>.*)$/', $route, $match)) {

            $service = (is_null($match['service']) || empty($match['service'])) ? $match['second_service'] : $match['service'];
            $sub_route = $match['route'] ?? '';

            if ($service == 'default') {
                $request = Request::create(URL::to('/') . '/api/' . $sub_route, $method);
                return Route::dispatch($request);
            }
            if (in_array($service, $service_keys)) {
                $domain = $services[$service]['domain'];


                list($can_pass, $middlewares) = $this->checkRoute($routes, $service, $route, $method, $sub_route);

                if (is_array($middlewares) && count($middlewares) > 0) {
                    $response = $this->checkMiddlewares($middlewares, $request);
                    if (!is_null($response))
                        return $response;
                }

                set_time_limit(0);
                if ($can_pass || !$services[$service]['just_current_routes']) {
                    $res = Http::withHeaders($headers)
                        ->withBody($contents, $content_type)
                        ->withUserAgent($user_agent)->
                        $method($domain . $sub_route);

                    if(in_array($res->header('Content-type'),ALL_MIME_TYPES)){
                        foreach ($res->headers() as $key => $value)
                            header("$key: $value");
                        echo $res->body();
                        return null;
                    }
                    $final = response($res->body());
                    foreach ($res->headers() as $key => $value)
                        $final->header($key, $value);

                    return $final;
                }


            }
            return ResponseData::error('gw_responses.not-found', null, 404);


        }


    }


    private function checkMiddlewares($middlewares, $request)
    {
        $kernel = app()->make(Kernel::class);
        foreach ($middlewares as $middleware) {
            $mid = explode(':', $middleware);
            $name = $mid[0];
            $arg = '';
            if (isset($mid[1]))
                $arg = $mid[1];

            $res = app()->make($kernel->getRouteMiddleware()[$name])->handle($request, function () {
                return null;
            }, $arg);
            if (!is_null($res))
                return $res;
        }

        return null;
    }

    /**
     * @param $routes
     * @param $service
     * @param $route
     * @param string $method
     * @param $sub_route
     * @return array
     */
    private function checkRoute($routes, $service, $route, string $method, $sub_route)
    {
        foreach ($routes as $c_route)
            if (in_array($service, $c_route['services']))
                foreach ($c_route['matches'] as $match_route)
                    if ($method == strtolower($match_route['method']))
                        foreach ($match_route['paths'] as $path)
                            if (preg_match('/' . $path . '/', $sub_route)) {
                                $middlewares = [];
                                if (isset($match_route['middlewares'])) {
                                    $middlewares = array_merge($middlewares, $match_route['middlewares']);
                                }
                                if (isset($c_route['middlewares'])) {
                                    $middlewares = array_merge($middlewares, $c_route['middlewares']);
                                }
                                return [true, $middlewares];
                            }
        return [false, null];
    }
}
