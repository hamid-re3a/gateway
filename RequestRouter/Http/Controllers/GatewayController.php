<?php

namespace RequestRouter\Http\Controllers;


use App\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GatewayController extends Controller
{

    /**
     * @hideFromAPIDocumentation
     */
    public function requestRouter(Request $request)
    {
        $route = str_replace('api/gateway/', '', $request->path());
        list($status, $final_route, $middlewares) = $this->getValidRoute($route, $request);

        $response = $this->checkMiddlewares($middlewares, $request);
        $this->setUserHeadersIfAuthenticated($request);

        if (!is_null($response)) {
            return $response;
        }

        if ($status == true) {
            return $this->getResponse($final_route, $request);
        }
        return api()->error('request_router.responses.not-found', null, 404);


    }


    /**
     * @hideFromAPIDocumentation
     */
    public function multiAggregate(Request $request)
    {
        $rules = [
            'routes' => 'required|array',
            'routes.*.route' => 'required',
            'routes.*.method' => 'required',
        ];
        $validated = Validator::validate($request->all(), $rules);


        $middlewares = [];

        $concurrent_requests = [];
        $concurrent_responses = [];
        foreach ($validated['routes'] as $route) {
            $route_method = strtolower($route['method']);
            list($status, $final_route, $route_middlewares) = $this->getValidRoute($route['route'], $request, $route_method);
            if (!is_null($route_middlewares))
                $middlewares = array_merge($middlewares, $route_middlewares);

            if ($status)
                if (Str::startsWith($final_route, URL::to('/'))) {
                    $concurrent_responses[$route['route']] = $this->getResponse($final_route, $request, $route_method, true);
                } else {
                    $concurrent_requests[] = ['route' => $final_route, 'method' => $route_method, 'name' => $route['route']];
                }
        }
        $response = $this->checkMiddlewares($middlewares, $request);
        $this->setUserHeadersIfAuthenticated($request);

        if (!is_null($response)) {
            return $response;
        }
        $headers = $this->getNecessaryHeaders($request);
        $user_agent = $request->userAgent();
        $contents = $request->getContent();
        $content_type = $request->getContentType() ?? "application/json";

        $responses = Http::withHeaders($headers)
            ->withBody($contents, $content_type)
            ->withUserAgent($user_agent)->pool(function (\Illuminate\Http\Client\Pool $pool) use ($concurrent_requests, $request) {
            $array = [];
            foreach ($concurrent_requests as $route) {
                $array[] = $pool->as($route['name'])->get($route['route']);
            }

            return $array;
        });


        foreach ($concurrent_requests as $route) {
            $concurrent_responses[$route['name']] = json_decode($responses[$route['name']]->body(), true);
        }

        header('Content-type: application/json');
        return api()->success('success', $concurrent_responses);

    }


    private function getValidRoute($route, $request, $method = null)
    {
        if (is_null($method))
            $method = strtolower($request->method());

        $routes = config('gateway.routes');
        $services = config('gateway.services');
        $service_keys = collect(config('gateway.services'))->keys()->toArray();

        if (Str::startsWith($route, '/'))
            return [false, null, null];
        if (preg_match('/^^(?!\W)((?P<service>.*?)(?=\/)\/(?P<route>.*)|(?P<second_service>.*))$/', $route, $match)) {

            $service = (is_null($match['service']) || empty($match['service'])) ? $match['second_service'] : $match['service'];
            $sub_route = $match['route'] ?? '';

            if ($service == 'default')
                return [true, URL::to('/api') . '/' . $sub_route, null];


            if (in_array($service, $service_keys)) {
                $domain = $services[$service]['domain'];
                $final_route = $domain . $sub_route;


                list($can_pass, $middlewares) = $this->checkRoute($routes, $service, $route, $method, $sub_route);

                if ($can_pass || !$services[$service]['just_current_routes']) {
                    return [true, $final_route, $middlewares];
                }
            }
            return [false, null, null];


        }
    }

    private function checkMiddlewares($middlewares, Request $request)
    {
        if (!is_array($middlewares) || count($middlewares) <= 0)
            return null;

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


    private function getResponse($final_route, Request $request, $method = null, $multi = false)
    {
        if (is_null($method))
            $method = strtolower($request->method());


        if (Str::startsWith($final_route, URL::to('/'))) {
            $request = Request::create($final_route, $method);
            return Route::dispatch($request);
        }
        $user_agent = $request->userAgent();
        $contents = $request->getContent();
        $content_type = $request->getContentType() ?? "application/json";


        $headers = $this->getNecessaryHeaders($request);
        $res = Http::withHeaders($headers)
            ->withBody($contents, $content_type)
            ->withUserAgent($user_agent)->
            $method($final_route);

        if (in_array($res->header('Content-type'), ALL_MIME_TYPES)) {
            if (!$multi)
                foreach ($res->headers() as $key => $value)
                    header("$key: $value");
            echo $res->body();
            return null;
        }
        $final = response($res->body());
        if (!$multi)
            foreach ($res->headers() as $key => $value)
                $final->header($key, $value);

        return $final;
    }

    /**
     * @param Request $request
     */
    private function setUserHeadersIfAuthenticated(Request $request): void
    {
        $request->headers->remove('X-user-id');
        $request->headers->remove('X-user-first-name');
        $request->headers->remove('X-user-last-name');
        $request->headers->remove('X-user-email');
        $request->headers->remove('X-user-username');
        if (auth()->check()) {

            $request->headers->set('X-user-id', auth()->user()->id);
            $request->headers->set('X-user-first-name', auth()->user()->first_name);
            $request->headers->set('X-user-last-name', auth()->user()->last_name);
            $request->headers->set('X-user-email', auth()->user()->email);
            $request->headers->set('X-user-username', auth()->user()->username);
        }
    }


    private function getNecessaryHeaders(Request $request): array
    {
        $headers = collect($request->header())->transform(function ($item) {
            return $item[0];
        })->toArray();
        unset($headers['accept-language']);
        unset($headers['accept-encoding']);
        unset($headers['sec-fetch-dest']);
        unset($headers['sec-fetch-user']);
        unset($headers['sec-fetch-mode']);
        unset($headers['sec-fetch-site']);
//        unset($headers['accept']);
        unset($headers['user-agent']);
        unset($headers['upgrade-insecure-requests']);
        unset($headers['sec-ch-ua-mobile']);
        unset($headers['sec-ch-ua']);
        unset($headers['cache-control']);
        unset($headers['connection']);
        unset($headers['host']);
        unset($headers['content-length']);
//        unset($headers['content-type']);
        unset($headers['cookie']);
        return $headers;
    }
}
